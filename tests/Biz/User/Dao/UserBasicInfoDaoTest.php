<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class UserBasicInfoDaoTest extends BaseTestCase
{
    public function testGetTableFields()
    {
        $basicInfo = array(
            'trueName' => '董剑斌',
            'departmentId' => 1,
            'rank' => 'P1',
            'phone' => '15757125389',
            'email' => 'dongjianbin@howzhi.com',
            'gender' => 'male',
            'bornTime' => '1470817352',
            'nation' => '汉族',
            'native' => '浙江台州',
            'height' => '173',
            'weight' => '58',
            'blood' => 'AB',
            'education' => '本科',
            'prefession' => '电子信息工程',
            'marriage' => '0',
            'address' => '浙江省台州市临海市',
            'postcode' => '317016',
            'Idcard' => '331082199307178894',
            'professionTitle' => 'PHP实习生',
            'householdType' => '农村户口',
            'residence' => '台州',
            'recordPlace' => '杭州市滨江区',
            'formerLaborShip' => '已解除',
            'politics' => '团员'
        );

        $basic = $this->getBasicDao()->create($basicInfo);

        $fields = $this->getBasicDao()->getTableFields();
        $this->assertEquals($fields, array_keys($basic));
    }

    protected function getBasicDao()
    {
        return self::$kernel['user_basic_dao'];
    }
}