<?php 

namespace Biz\Department;

interface DepartmentService
{
    public function createDepartment($department);

    public function findDepartments();

    public function deleteDepartment($id);

    public function getDepartment($id);

    public function updateDepartment($id, $fields);

    public function getDepartmentByName($departmentName);
}