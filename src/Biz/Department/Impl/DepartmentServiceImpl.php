<?php 

namespace Biz\Department\Impl;

use Biz\Department\DepartmentService;
use Codeages\Biz\Framework\Service\BaseService;

class DepartmentServiceImpl extends BaseService implements DepartmentService
{

    public function createDepartment($fields)
    {
        $department = $this->getDepartmentDao()->getByName($fields['name']);
        
        if (!empty($department)) {
            throw new \Exception('该部门名字已经存在。');
        }

        return $this->getDepartmentDao()->create($fields);
    }

    public function findDepartments()
    {   
       return $this->getDepartmentDao()->find();
    }

    public function deleteDepartment($id)
    {
        $department = $this->getDepartment($id);

        if ($department['amount'] > 0) {
            throw new \Exception('该部门尚有成员。');
        }

        return $this->getDepartmentDao()->delete($id);
    }

    public function getDepartment($id)
    {
        return $this->getDepartmentDao()->get($id);
    }

    public function getDepartmentByName($name)
    {
        return $this->getDepartmentDao()->getByName($name);
    }

    public function updateDepartment($id, $fields)
    {
        return $this->getDepartmentDao()->update($id, $fields);
    }

    protected function getDepartmentDao()
    {
        return $this->biz['department_dao'];
    }
}