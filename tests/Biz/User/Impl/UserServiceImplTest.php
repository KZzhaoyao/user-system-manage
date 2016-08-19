<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;
use AppBundle\Common\ArrayToolkit;

class UserServiceImplTest extends BaseTestCase
{   
    private $user = array(
            'basic' => array(
                'number' =>   '0011',
                'trueName' =>   '李云龙',
                'departmentId' =>   1,
                'rank' =>   'p10',
                'phone' =>   '15888855888',
                'email' =>   '258555@qq.com',
                'gender' =>   'male',
                'bornTime' => '2016-06-08',
                'nation' =>   '汉',
                'native' =>   '浙江杭州',
                'height' =>   '190',
                'weight' =>   '122',
                'blood' =>   'AB',
                'education' =>   '本科',
                'prefession' =>   '计算机',
                'marriage' =>   '否',
                'address' =>   '浙江杭州',
                'postcode' =>   '325800',
                'Idcard' =>   '33032719950104453X',
                'professionTitle' =>   '工程师',
                'householdType' =>   '农村',
                'residence' =>   '浙江杭州滨江',
                'recordPlace' =>   '浙江杭州滨江',
                'formerLaborShip' =>   '已解除',
                'joinTime' => '2016-06-08',
                'politics' =>   '预备党员',
            ),
            'family' => array(
                array(
                    'phone' => '18142004001',
                    'member' => '爸爸',
                    'trueName' => '赵耀',
                    'age' => '18',
                    'job' => '务工'
                ),
                array(
                    'phone' => '18142004001',
                    'member' => '爸爸',
                    'trueName' => '赵耀',
                    'age' => '18',
                    'job' => '务工'
                ),
            ),
            'education' => array(
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'schoolName' => '巴中中学',
                    'profession' => '软件工程',
                    'position' => '董事长'
                ),
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'schoolName' => '巴中中学1',
                    'profession' => '软件工程1',
                    'position' => '董事长1'
                )
            ),
            'work' => array(
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'company' => '阔知网络1',
                    'position' => '开发1',
                    'leaveReason' => '111'
                ),
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'company' => '阔知网络',
                    'position' => '开发',
                    'leaveReason' => '222'
                )
            ),
            'other' => array(
                'reward' => '111',
                'selfAssessment' => '222'
            )
    );

    public function testAddUser()
    {
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetBasic($data)
    {   
        $this->getUserService()->createUser($data);
        $basic = $this->getUserService()->getBasic(1);
        $basic['number'] = '0010';
        $data['basic']['joinTime'] = strtotime($data['basic']['joinTime']);
        $data['basic']['bornTime'] = strtotime($data['basic']['bornTime']);
        $this->assertEquals($data['basic'], $basic);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetOtherInfo($data)
    {   
        $this->getUserService()->createUser($data);
        $otherInfo = $this->getUserService()->getOtherInfoByUserId(1);
        $this->assertEquals($data['other']['id'], $otherInfo['id']);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testFindFamilyMembers($data)
    {   
        $this->getUserService()->createUser($data);
        $familyMembers = $this->getUserService()->findFamilyMembers(1);
        $this->assertEquals($data['family'], $familyMembers);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testFindEduExperiences($data)
    {   
        $this->getUserService()->createUser($data);
        $education = $this->getUserService()->findEduExperiences(1);
        foreach ($data['education'] as $key => $value) {
            $data['education'][$key]['startTime'] = strtotime($value['startTime']);
            $data['education'][$key]['endTime'] = strtotime($value['endTime']);
        }
        $this->assertEquals($data['education'], $education);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testFindWorkExperiences($data)
    {   
        $this->getUserService()->createUser($data);
        $workInfo = $this->getUserService()->findWorkExperiences(1);
        foreach ($data['work'] as $key => $value) {
            $data['work'][$key]['startTime'] = strtotime($value['startTime']);
            $data['work'][$key]['endTime'] = strtotime($value['endTime']);
        }
        $this->assertEquals($data['work'], $workInfo);
    }

    public function testCreateUser()
    {
        $user = array(
            'status' => 'on',
            'roles' => array('ROLE_USER'),
            'number' => '0011',
            'joinTime' => '2016-06-08'
        );
        $user1 = $this->getUserService()->createUser($this->user);
        $user['joinTime'] = strtotime($user['joinTime']);

        $this->assertEquals($user['status'], $user1['status']);
        $this->assertEquals($user['roles'], $user1['roles']);
        $this->assertEquals($user['number'], $user1['number']);
        $this->assertEquals($user['joinTime'], $user1['joinTime']);
    }

    /**
    *@expectedException Exception
    */
    public function testCreateUserException()
    {
        $user = array(
            'basic' => array(
                'number' => '1x11',
                'trueName' => '',
                'rank' => '',
                'phone' => '1234',
                'email' => '123',
                'professionTitle' => '',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['number'], $user1['number']);
        $user = array(
            'basic' => array(
                'number' => '1111',
                'trueName' => '',
                'rank' => '',
                'phone' => '1234',
                'email' => '123',
                'professionTitle' => '',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['trueName'], $user1['trueName']);
        $user = array(
            'basic' => array(
                'number' => '1111',
                'trueName' => 'zy',
                'rank' => '',
                'phone' => '1234',
                'email' => '123',
                'professionTitle' => '',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['rank'], $user1['rank']);

        $user = array(
            'basic' => array(
                'number' => '1111',
                'trueName' => 'zy',
                'rank' => '123',
                'phone' => '1234',
                'email' => '123',
                'professionTitle' => '',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['phone'], $user1['phone']);

        $user = array(
            'basic' => array(
                'number' => '1111',
                'trueName' => 'zy',
                'rank' => '123',
                'phone' => '18142004001',
                'email' => '123',
                'professionTitle' => '',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['email'], $user1['email']);

        $user = array(
            'basic' => array(
                'number' => '1111',
                'trueName' => 'zy',
                'rank' => '123',
                'phone' => '18142004001',
                'email' => '123@qq.com',
                'professionTitle' => '',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['professionTitle'], $user1['professionTitle']);

        $user = array(
            'basic' => array(
                'number' => '1111',
                'trueName' => 'zy',
                'rank' => '123',
                'phone' => '18142004001',
                'email' => '123@qq.com',
                'professionTitle' => 'zy',
                'joinTime' => ''
            )
        );
        $user1 = $this->getUserService()->createUser($user);
        $this->assertEquals($user['joinTime'], $user1['joinTime']);
    }

    public function testSearchAllUsers()
    {
        $fields = array(
            'name' => '技术部'
        );
        $user = $this->user;
        $user = $this->getUserService()->createUser($user);
        $department = $this->getDepartmentService()->createDepartment($fields);

        $conditions = array(
            'name' => '技术部',
            'gender' => 'male',
            'education' => '本科',
            'trueName' => '李云龙'
        );

        $searchUsers = $this->getUserService()->searchAllUsers($conditions, array('number','ASC'), 0, PHP_INT_MAX);
        $searchCount = count($searchUsers);

        $this->assertEquals(1,$searchCount);
    }

    public function testUpdate()
    {
        $user = $this->getUserService()->createUser($this->user);

        $id = 1;
        $userTest = array(
            'basic' => array(
                'id' => 1,
                'trueName' =>   '李云龙',
                'departmentId' =>   1   ,
                'rank' =>   'p10',
                'phone' =>   '15888855888',
                'email' =>   '258555@qq.com',
                'gender' =>   'male',
                'bornTime' => 1296576000,
                'nation' =>   '汉',
                'native' =>   '浙江杭州',
                'height' =>   '190',
                'weight' =>   '122',
                'blood' =>   'AB',
                'education' =>   '本科',
                'prefession' =>   '计算机',
                'marriage' =>   '否',
                'address' =>   '浙江杭州',
                'postcode' =>   '325800',
                'Idcard' =>   '33032719950104453X',
                'professionTitle' =>   '工程师',
                'householdType' =>   '农村',
                'residence' =>   '浙江杭州滨江',
                'recordPlace' =>   '浙江杭州滨江',
                'formerLaborShip' =>   '已解除',
                'joinTime' => '2016-06-08',
                'politics' =>   '预备党员',
            ),
            'family' => array(
                array(
                    'phone' => '18142004001',
                    'member' => '爸爸',
                    'trueName' => '赵耀',
                    'age' => '18',
                    'job' => '务工'
                ),
                array(
                    'phone' => '18142004001',
                    'member' => '爸爸',
                    'trueName' => '赵耀',
                    'age' => '18',
                    'job' => '务工'
                ),
                array(),
            ),
            'education' => array(
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'schoolName' => '巴中中学',
                    'profession' => '软件工程',
                    'position' => '董事长'
                ),
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'schoolName' => '巴中中学1',
                    'profession' => '软件工程1',
                    'position' => '董事长1'
                )
            ),
            'work' => array(
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'company' => '阔知网络1',
                    'position' => '开发1',
                    'leaveReason' => '111'
                ),
                array(
                    'startTime' => '2016-06-08',
                    'endTime' => '2016-06-08',
                    'company' => '阔知网络',
                    'position' => '开发',
                    'leaveReason' => '222'
                )
            ),
            'other' => array(
                'id' => '1',
                'reward' => '111',
                'selfAssessment' => '222'
            )
        );

        $user = $this->getUserService()->update($id, $userTest);
        $this->assertEquals($user['id'], $userTest['basic']['id']);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetCompleteData($data)
    {
        $user = $this->getUserService()->createUser($data);
        $id = 1;
        $resultData = $this->getUserService()->getCompleteData($id);
        $this->assertEquals($user['id'], $resultData['basic']['id']);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testUpdateUser($data)
    {
        $user = $this->getUserService()->createUser($data);

        $user = $this->getUserService()->getUser($user['id']);

        $fields = array(
            'number' => '0002',
            'status' => 'off'
        );

        $user = array_merge($user, $fields);

        $this->getUserService()->updateUser($user['id'], $fields);
        $update = $this->getUserService()->getUser($user['id']);
        $this->assertEquals($user, $update);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetUser($data)
    {
        $insertUser = $this->getUserService()->createUser($data);

        $user = $this->getUserService()->getUser($insertUser['id']);

        $this->assertEquals($insertUser, $user);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetUserByUsername($data)
    {
        $insertUser = $this->getUserService()->createUser($data);

        $user = $this->getUserService()->getUserByUsername($insertUser['username']);
        $this->assertEquals($insertUser, $user);
    }

    /**
     * @dataProvider additionProvider
     */
    public function testGetUserByNumber($data)
    {
        $insertUser = $this->getUserService()->createUser($data);

        $user = $this->getUserService()->getUserByNumber($insertUser['number']);
        $this->assertEquals($insertUser, $user);
    }

    public function testRegister()
    {
        $info = array(
            'username' => 'admin',
            'number' => '0000',
            'password' => 'kaifazhe',
            'roles' => array('ROLE_ADMIN'),
            'trueName' => 'Admin'
        );

        $registerUser = $this->getUserService()->register($info);

        $user = $this->getUserService()->getUser($registerUser['id']);

        $this->assertEquals($registerUser, $user);
    }

 

    public function additionProvider()
    {
        return [
            [array(
                "basic" => array(
                    "id" => 1,
                    "userId" => 1,
                    "departmentId" => 1,
                    "rank" => "p20",
                    "number" => "0010",
                    "trueName" => "陆昉宇",
                    "phone" => 13411231234,
                    "email" => "594@qq.com",
                    "gender" => "male",
                    "bornTime" => '2016-05-06',
                    "native" => "中国海宁",
                    "nation" => "汉族",
                    "height" => "177cm",
                    "weight" => "55kg",
                    "blood" => "AB",
                    "education" => "博士",
                    "prefession" => "计科",
                    "joinTime" => '2016-05-06',
                    "marriage" => 0,
                    "residence" => "海宁",
                    "address" => "没考虑",
                    "postcode" => 310000,
                    "Idcard" => 330481199412170055,
                    "professionTitle" => "PHP程序员",
                    "householdType" => "城市",
                    "recordPlace" => "杭州",
                    "formerLaborShip" => "已解除",
                    "politics" => "群众",
                ),
                "family" => array(
                    array(
                        "id" => 1,
                        "userId" => 1,
                        "member" => "爸爸",
                        "trueName" => "陆昉宇",
                        "age" => 30,
                        "job" => "那几款",
                        "phone" => 13511292312,
                    ),
                    array(
                        "id" => 2,
                        "userId" => 1,
                        "member" => "爸爸",
                        "trueName" => "陆昉宇",
                        "age" => 30,
                        "job" => "那几款",
                        "phone" => 13511292312,
                    )
                ),
                "work" => array(
                    array(
                        "id" => 1,
                        "userId" => 1,
                        "startTime" => '2016-05-06',
                        "endTime" => '2016-05-06',
                        "company" => "方法",
                        "position" => "发的",
                        "leaveReason" => "等等",
                    )
                ),
                "education" => array(
                    array(
                        "id" => 1,
                        "userId" => 1,
                        "startTime" => '2016-05-06',
                        "endTime" => '2016-05-06',
                        "schoolName" => "你",
                        "profession" => "方法",
                        "position" => "方法",
                    ),
                    array(
                        "id" => 2,
                        "userId" => 1,
                        "startTime" => '2016-05-06',
                        "endTime" => '2016-05-06',
                        "schoolName" => "你",
                        "profession" => "方法",
                        "position" => "方法",
                    )
                ),
                "other" => array(
                    "id" => 1,
                    "userId" => 1,
                    "reward" => "覅UN会不会就不喝酒",
                    "selfAssessment" => "和基本和金额为备份和文件",
                )
            )]
        ];
    }

    protected function getUserService()
    {
        return self::$kernel['user_service'];
    }

    protected function getBasicDao()
    {
        return self::$kernel['user_basic_dao'];
    }

    protected function getDepartmentService()
    {
        return self::$kernel['department_service'];
    }
}