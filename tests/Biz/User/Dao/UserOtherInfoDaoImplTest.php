<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class UserOtherInfoDaoTest extends BaseTestCase
{
    public function testGetTableFields()
    {
        $otherInfo = array(
            'userId' => 1,
            'reward' => '英语四级',
            'selfAssessment' => '很好很厉害。'
        );

        $otherInfo = $this->getOtherInfoDao()->create($otherInfo);

        $fields = $this->getOtherInfoDao()->getTableFields();

        $this->assertEquals($fields, array_keys($otherInfo));
    }

    protected function getOtherInfoDao()
    {
        return self::$kernel['other_info_dao'];
    }
}