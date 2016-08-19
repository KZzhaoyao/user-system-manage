<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class DepartmentServicrImplTest extends BaseTestCase
{
    private $department = array(
            'name' =>'技术部',
            'amount' => 0
    );

    public function testCreateDepartment()
    {
        $department = $this->department;
        $dataDepartment = $this->getDepartmentService()->createDepartment($department);
        
        $this->assertEquals($department['name'], $dataDepartment['name']);
        $this->assertEquals($department['amount'], $dataDepartment['amount']);
    }

    public function testGetDepartmentByName()
    {
        $department = array(
            'name' =>'测试部',
            'amount' => 0,
        );
        $datadepartment = $this->getDepartmentService()->createDepartment($department);

        $department = $this->getDepartmentService()->getDepartmentByName('测试部');

        $this->assertEquals($datadepartment, $department);
    }

    public function testFindDepartments()
    {
        $departments = array(
            'name' =>'测试部',
            'amount' => 0,
        );
        $datadepartments = $this->getDepartmentService()->createDepartment($departments);
        
        $department = $this->department;
        $dataDepartment = $this->getDepartmentService()->createDepartment($department);
        
        $findDepartment = $this->getDepartmentService()->findDepartments();
        
        $this->assertEquals($department['name'],$findDepartment[1]['name']);
        $this->assertEquals($department['amount'],$findDepartment[1]['amount']);
        $this->assertEquals($departments['name'],$findDepartment[0]['name']);
        $this->assertEquals($departments['amount'],$findDepartment[0]['amount']);

    }

    public function testDeleteDepartment()
    {
        $department = $this->department;
        $dataDepartment = $this->getDepartmentService()->createDepartment($department);
        
        $deleteDataDepartment = $this->getDepartmentService()->deleteDepartment(1);

        $this->assertNull($deleteDataDepartment['name']);
        $this->assertNull($deleteDataDepartment['amount']);
    }

    public function testUpdateDepartment()
    {
        $department = $this->department;
        $dataDepartment = $this->getDepartmentService()->createDepartment($department);

        $updateDataDepartment = $this->getDepartmentService()->updateDepartment(1, array(
                'name'=>'测试部',
                'amount'=>1,
        ));

        $this->assertNotSame($department['name'],$updateDataDepartment['name']);
        $this->assertNotSame($department['amount'],$updateDataDepartment['amount']);
    }
    
    protected function getDepartmentService()
    {
        return self::$kernel['department_service'];
    }
}