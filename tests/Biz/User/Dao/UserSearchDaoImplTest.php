<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class UserSearchDaoImplTest extends BaseTestCase
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
            'bornTime' => '2016-05-06',
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
            'joinTime' => '2016-05-06',
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
                'startTime' => '2016-05-06',
                'endTime' => '2016-05-06',
                'schoolName' => '巴中中学',
                'profession' => '软件工程',
                'position' => '董事长'
            ),
            array(
                'startTime' => '2016-05-06',
                'endTime' => '2016-05-06',
                'schoolName' => '巴中中学1',
                'profession' => '软件工程1',
                'position' => '董事长1'
            )
        ),
        'work' => array(
            array(
                'startTime' => '2016-05-06',
                'endTime' => '2016-05-06',
                'company' => '阔知网络1',
                'position' => '开发1',
                'leaveReason' => '111'
            ),
            array(
                'startTime' => '2016-05-06',
                'endTime' => '2016-05-06',
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

    public function testSearchAll()
    {
        $fields = array(
            'name' => '技术部'
        );
        $user = $this->user;
        $user = $this->getUserService()->createUser($user);
        $department = $this->getDepartmentService()->createDepartment($fields);

        $conditions = array(
            'searchTime' => 'joinTime',
            'startTime' => '1462464000',
            'endTime' => '1462464000',
            'departmentId' => '1',
            'gender' => 'male',
            'education' => '本科',
            'trueName' => '李云龙'
        );

        $users = $this->getSearchDao()->searchAll($conditions, array('number','ASC'), 0, PHP_INT_MAX);
        $this->assertEquals($conditions['departmentId'], $users[0]['departmentId']);
        $this->assertEquals($conditions['gender'], $users[0]['gender']);
        $this->assertEquals($conditions['education'], $users[0]['education']);
        $this->assertEquals($conditions['trueName'], $users[0]['trueName']);
    }

    public function testSearchDepartmentUsers()
    {
        $fields = array(
            'name' => '技术部'
        );
        $user = $this->user;
        $user = $this->getUserService()->createUser($user);
        $department = $this->getDepartmentService()->createDepartment($fields);

        $conditions = array(
            'searchTime' => 'joinTime',
            'startTime' => '1462464000',
            'endTime' => '1462464000',
            'departmentId' => '1',
            'gender' => 'male',
            'education' => '本科',
            'trueName' => '李云龙'
        );

        $users = $this->getSearchDao()->searchAll($conditions, array('number','ASC'), 0, PHP_INT_MAX);
        $this->assertEquals($conditions['departmentId'], $users[0]['departmentId']);
        $this->assertEquals($conditions['gender'], $users[0]['gender']);
        $this->assertEquals($conditions['education'], $users[0]['education']);
        $this->assertEquals($conditions['trueName'], $users[0]['trueName']);
    }

    public function testSearchAllCounts()
    {
        $fields = array(
            'name' => '技术部'
        );
        $user = $this->user;
        $user = $this->getUserService()->createUser($user);
        $department = $this->getDepartmentService()->createDepartment($fields);

        $conditions = array(
            'searchTime' => 'joinTime',
            'startTime' => '1462464000',
            'endTime' => '1462464000',
            'departmentId' => '1',
            'gender' => 'male',
            'education' => '本科',
            'trueName' => '李云龙'
        );

        $searchCount = $this->getSearchDao()->searchAllCounts($conditions);
        $this->assertEquals(1,$searchCount);
    }

    public function testSearchDepartmentUserCounts()
    {
        $fields = array(
            'name' => '技术部'
        );
        $user = $this->user;
        $user = $this->getUserService()->createUser($user);
        $department = $this->getDepartmentService()->createDepartment($fields);

        $conditions = array(
            'searchTime' => 'joinTime',
            'startTime' => '1462464000',
            'endTime' => '1462464000',
            'departmentId' => '1',
            'gender' => 'male',
            'education' => '本科',
            'trueName' => '李云龙'
        );

        $searchCount = $this->getSearchDao()->searchAllCounts($conditions);
        $this->assertEquals(1,$searchCount);
    }

    protected function getSearchDao()
    {
        return self::$kernel['user_search_dao'];
    }

    protected function getUserService()
    {
        return self::$kernel['user_service'];
    }

    protected function getDepartmentService()
    {
        return self::$kernel['department_service'];
    }
}