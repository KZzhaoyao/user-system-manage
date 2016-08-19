<?php

namespace Biz\User\Impl;

use Codeages\Biz\Framework\Service\BaseService;
use Biz\User\UserService;
use AppBundle\Common\ArrayToolkit;
use AppBundle\Common\Upload;

class UserServiceImpl extends BaseService implements UserService
{
    public function createUser($fields)
    {
        $this->validate($fields);
        $userTableFields = $this->getDao('user_dao')->getTableFields();
        $user = ArrayToolkit::parts($fields['basic'], $userTableFields);
        $user['status'] = 'on';
        $user['roles'] = array('ROLE_USER');
        if (!empty($user['joinTime'])) {
            $user['joinTime'] = strtotime($user['joinTime']);
        }
        $user['password'] = 'kaifazhe';
        $user['username'] = $user['number'];
        $user['salt'] = md5(time().mt_rand(0, 1000));
        $user['password'] = $this->biz['password_encoder']->encodePassword($user['password'], $user['salt']);

        $lastInsertUser = $this->getDao('user_dao')->create($user);

        $otherTableFields = $this->getDao('other_info_dao')->getTableFields();
        $other = ArrayToolkit::parts($fields['other'], $otherTableFields);
        $other['userId'] = $lastInsertUser['id'];
        $this->getDao('other_info_dao')->create($other);

        $basicTableFields = $this->getDao('user_basic_dao')->getTableFields();
        $basic = ArrayToolkit::parts($fields['basic'], $basicTableFields);
        $basic['userId'] = $lastInsertUser['id'];

        if (!empty($basic['bornTime'])) {
            $basic['bornTime'] = strtotime($basic['bornTime']);
        }
        
        $this->getDao('user_basic_dao')->create($basic);
        $department = $this->getDepartmentService()->getDepartment($basic['departmentId']);
        $departmentCount = $department['amount'] + 1;
        $this->getDepartmentService()->updateDepartment($department['id'], array('amount'=>$departmentCount));

        $familyTableFields = $this->getDao('family_member_dao')->getTableFields();
        foreach ($fields['family'] as $member) {
            $member = ArrayToolkit::parts($member, $familyTableFields);
            $member['userId'] = $lastInsertUser['id'];
            $this->getDao('family_member_dao')->create($member);
        }

        $eduTableFields = $this->getDao('edu_experience_dao')->getTableFields();
        foreach ($fields['education'] as $education) {
            $education = ArrayToolkit::parts($education, $eduTableFields);
            $education['userId'] = $lastInsertUser['id'];
            if (!empty($education['startTime'])) {
                $education['startTime'] = strtotime($education['startTime']);
            }
            if (!empty($education['endTime'])) {
                $education['endTime'] = strtotime($education['endTime']);
            }
            $this->getDao('edu_experience_dao')->create($education);
        }

        $workTableFields = $this->getDao('work_experience_dao')->getTableFields();
        foreach ($fields['work'] as $work) {
            $work = ArrayToolkit::parts($work, $workTableFields);
            $work['userId'] = $lastInsertUser['id'];
            if (!empty($work['startTime'])) {
                $work['startTime'] = strtotime($work['startTime']);
            }
            if (!empty($work['endTime'])) {
                $work['endTime'] = strtotime($work['endTime']);
            }
            $this->getDao('work_experience_dao')->create($work);
        }

        return $lastInsertUser;
    }

    public function importUsers($users)
    {
        foreach ($users as $user) {
            $presentUser = $this->getUserByNumber($user['basic']['number']);
            if (!empty($presentUser)) {
                continue;
            }

            $department = $this->getDepartmentService()->getDepartmentByName($user['basic']['department']);

            if (empty($department)) {
                $user['basic']['departmentId'] = 1;
            } else {
                $user['basic']['departmentId'] = $department['id'];
            }

            $this->createUser($user);
        }
    }

    public function update($id, $fields)
    {
        $this->editValidate($id, $fields);
        $this->truncateDataById($id);
        $currentBasic = $this->getDao('user_basic_dao')->getByUserId($id);

        $userTableFields = $this->getDao('user_dao')->getTableFields();
        $user = ArrayToolkit::parts($fields['basic'], $userTableFields);

        if (isset($user['joinTime'])) {
            $user['joinTime'] = strtotime($user['joinTime']);
        }
        
        $this->getDao('user_dao')->update($id, $user);

        $userBasicTableFields = $this->getDao('user_basic_dao')->getTableFields();
        $userBasic = ArrayToolkit::parts($fields['basic'], $userBasicTableFields);
        $userBasic['bornTime'] = strtotime($userBasic['bornTime']);

        if (isset($userBasic['departmentId']) && $userBasic['departmentId'] != $currentBasic['departmentId']) {
            $department = $this->getDepartmentService()->getDepartment($userBasic['departmentId']);
            $departmentCount = $department['amount'] + 1;
            $this->getDepartmentService()->updateDepartment($department['id'], array('amount'=>$departmentCount));
            $beforeDepartment = $this->getDepartmentService()->getDepartment($currentBasic['departmentId']);
            $beforeDepartmentCount = $beforeDepartment['amount'] - 1;
            $this->getDepartmentService()->updateDepartment($beforeDepartment['id'], array('amount'=>$beforeDepartmentCount));
        }
        unset($userBasic['id']);
        $this->getDao('user_basic_dao')->update($currentBasic['id'], $userBasic);

        $this->editHelper($id, $fields, 'family', 'family_member_dao');

        $this->editHelper($id, $fields, 'education', 'edu_experience_dao');

        $this->editHelper($id, $fields, 'work', 'work_experience_dao');

        $otherTableFields = $this->getDao('other_info_dao')->getTableFields();
        $other = ArrayToolkit::parts($fields['other'], $otherTableFields);

        $this->getDao('other_info_dao')->update($other['id'], $other);

        return $user;
    }

    protected function editHelper($id, $fields, $tableName, $daoName)
    {
        $tableFields = $this->getDao($daoName)->getTableFields();
        foreach ($fields[$tableName] as $tableData) {
            
            $tableData = ArrayToolkit::parts($tableData, $tableFields);
            $tableData = array_filter($tableData);

            if (empty($tableData)) {
                continue;
            }

            foreach ($tableData as $key => $data) {
                if (stripos($key, 'time') != false) {
                    $tableData[$key] = strtotime($data);
                }
            }

            unset($tableData['id']);
            $tableData['userId'] = $id;

            $this->getDao($daoName)->create($tableData);
        }
    }

    public function getCompleteData($id)
    {
        $data = array();

        $data['user'] =  $this->getUser($id);
        $data['basic'] = $this->getBasic($id);
        $data['familyMembers'] = $this->findFamilyMembers($id);
        $data['eduExperiences'] = $this->findEduExperiences($id);
        $data['workInfos'] = $this->findWorkExperiences($id);
        $data['otherInfo'] = $this->getOtherInfoByUserId($id);

        return $data;
    }

    protected function truncateDataById($id)
    {
        $this->getDao('family_member_dao')->deleteByUserId($id);
        $this->getDao('edu_experience_dao')->deleteByUserId($id);
        $this->getDao('work_experience_dao')->deleteByUserId($id);
    }

    /**
     * user表
     */
    public function updateUser($id, $fields)
    {
        return $this->getDao('user_dao')->update($id, $fields);
    }

    public function getUser($id)
    {
        return $this->getDao('user_dao')->get($id);
    }

    public function getUserByUsername($username)
    {
        return $this->getDao('user_dao')->getByUsername($username);
    }

    public function getUserByNumber($number)
    {
        return $this->getDao('user_dao')->getUserByNumber($number);
    }

    public function register($user)
    {
        $user['salt'] = md5(time().mt_rand(0, 1000));
        $user['password'] = $this->biz['password_encoder']->encodePassword($user['password'], $user['salt']);
        if (empty($user['roles'])) {
            $user['roles'] = array('ROLE_USER');
        }
        if (isset($user['trueName'])) {
            $trueName = $user['trueName'];
            unset($user['trueName']);
        }

        $user = $this->getDao('user_dao')->create($user);
        $this->getDao('other_info_dao')->create(array('userId'=>$user['id']));
        if (isset($trueName)) {
            $this->getDao('user_basic_dao')->create(array('userId'=>$user['id'],'trueName'=>$trueName));
        } else {
            $this->getDao('user_basic_dao')->create(array('userId'=>$user['id']));
        }
        $this->getDao('family_member_dao')->create(array('userId'=>$user['id']));
        $this->getDao('work_experience_dao')->create(array('userId'=>$user['id']));
        $this->getDao('edu_experience_dao')->create(array('userId'=>$user['id']));

        return $user;
    }

    public function uploadImage($userId, $image, $type)
    {
        $image = new Upload($image);
        $user = $this->getUser($userId);
        $oldPath = $user['img'.$type];
        $path = $image->moveToDirectory($userId, $oldPath, $type);
        $this->getDao('user_dao')->update($userId, array(
            'img'.$type => $path
        ));

        return $path;
    }

    /**
     * user_basic表
     */
    public function getBasic($userId)
    {
        $basic = $this->getDao('user_basic_dao')->getByUserId($userId);
        $joinTime = $this->getDao('user_dao')->getJoinTime($userId);    
        $basic['joinTime'] = $joinTime['joinTime'];

        return $basic;
    }

    public function findDepartmentsCounts($departmentNames)
    {   
        $counts = array();

        foreach ($departmentNames as $departmentName) {
            $counts[]['count'] = $this->getDao('user_basic_dao')->count(array(
                'department' => $departmentName['departmentName']
            ));
        }

        return $counts;
    }

    /**
     * family_member表
     */
    public function findFamilyMembers($userId)
    {
        return $this->getDao('family_member_dao')->findFamilyMembers($userId);
    }

    /**
     * edu_experience表
     */
    public function findEduExperiences($userId)
    {   
        return $this->getDao('edu_experience_dao')->findEduExperiences($userId);
    }

    /**
     * work_experience表
     */
    public function findWorkExperiences($userId)
    {
        return $this->getDao('work_experience_dao')->findWorkExperiences($userId);
    }

    /**
     * other_info表
     */
    public function getOtherInfoByUserId($userId)
    {
        return $this->getDao('other_info_dao')->getByUserId($userId);
    }

    public function searchAllUsers($conditions, $orderBy, $start, $limit)
    {   
        return $this->getDao('user_search_dao')->searchAll($conditions, $orderBy, $start, $limit);
    }

    public function searchDepartmentUsers($conditions, $orderBy, $start, $limit)
    {
        return $this->getDao('user_search_dao')->searchDepartmentUsers($mysql, $orderBy, $start, $limit);
    }

    public function searchAllUserCounts($conditions)
    {
        return $this->getDao('user_search_dao')->searchAllCounts($conditions);
    }

    public function searchDepartmentUserCounts($conditions)
    {
        return $this->getDao('user_search_dao')->searchDepartmentUserCounts($conditions);
    }

    protected function validate($user)
    {
        if(empty($user['basic']['number'])) {
            throw new \Exception("请输入工号"); 
        }

        $number = $this->getUserByNumber($user['basic']['number']);
        if (!empty($number) || !preg_match('/^\d{4}$/', $user['basic']['number'])) {
            throw new \Exception("工号已经存在或者输入格式不正确");
        }

        if(empty($user['basic']['trueName'])) {
            throw new \Exception("请输入姓名"); 
        }

        if(empty($user['basic']['rank'])) {
            throw new \Exception("请输入职级");
        }
        if(empty($user['basic']['phone']) || !preg_match("/^1[3|4|5|7|8]\d{9}$/", $user['basic']['phone'])) {
            throw new \Exception("手机号输入有误");
        }
        if(!preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $user['basic']['email'])){
            throw new \Exception("邮箱格式不正确"); 
        } 
        if(empty($user['basic']['professionTitle'])) {
            throw new \Exception("请输入职称");
        }

        if(empty($user['basic']['joinTime'])) {
            throw new \Exception("请输入入职时间"); 
        }
    }

    protected function editValidate($id, $user)
    {
        if ($this->isAdmin($id)) {
            if(empty($user['basic']['rank'])) {
                throw new \Exception("请输入职级");
            }

            if(empty($user['basic']['professionTitle'])) {
                throw new \Exception("请输入职称");
            }

            if(empty($user['basic']['joinTime'])) {
                throw new \Exception("请输入入职时间"); 
            }
        }

        if(empty($user['basic']['trueName'])) {
            throw new \Exception("请输入姓名"); 
        }

        if(empty($user['basic']['phone']) || !preg_match("/^1[3|4|5|7|8]\d{9}$/", $user['basic']['phone'])) {
            throw new \Exception("手机号输入有误");
        }

        if(!preg_match("/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $user['basic']['email'])){
            throw new \Exception("邮箱格式不正确"); 
        }
    }

    protected function isAdmin($id)
    {
        $userInfo = $this->getUser($id);
        if (in_array('ROLE_ADMIN', $userInfo['roles'])) {
            return true;
        }

        return false;
    }

    protected function checkIdCard($id)
    {
        $len = strlen($id);
        if ($len != 18) {
            return 0;
        }

        $a = str_split($id,1);
        $w = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        $c = array(1,0,'X',9,8,7,6,5,4,3,2);
        $sum = 0;
        for ($i=0;$i<17;$i++){
            $sum = $sum + $a[$i] * $w[$i];
        }

        $r = $sum%11;
        $res = $c[$r];
        
        if ($res == $a[17]) {
            return 1;
        } else {
            return 0;
        }
    }
    /**
     * user_dao,user_basic_dao,family_member_dao
     * work_experience_dao,confirm_person,edu_experience_dao
     * other_info
     */
    protected function getDepartmentService()
    {
        return $this->biz['department_service'];
    }

    protected function getDao($dao)
    {
        return $this->biz[$dao];
    }
}
