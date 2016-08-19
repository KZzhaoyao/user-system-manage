<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class UserConfirmInfoDaoTest extends BaseTestCase
{
    public function testGetTableFields()
    {
        $confirmInfo = array(
            'userId' => 1,
            'trueName' => '董剑斌',
            'job' => '浙江台州程序员',
            'phone' => '15757125389'
        );

        $confirmInfo = $this->getConfirmPersonDao()->create($confirmInfo);

        $fields = $this->getConfirmPersonDao()->getTableFields();

        $this->assertEquals($fields, array_keys($confirmInfo));
    }

    protected function getConfirmPersonDao()
    {
        return self::$kernel['confirm_person_dao'];
    }
}