<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserOtherInfoDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserOtherInfoDaoImpl extends GeneralDaoImpl implements UserOtherInfoDao
{
    protected $table = 'other_info';

    public function getTableFields()
    {
        $sql = "SELECT * FROM {$this->table()}";
        $select = $this->db()->query($sql);
        $columnCount = $select->columnCount();
        for ($count=0;$count<$columnCount;$count++) {
            $meta = $select->getColumnMeta($count);
            $columns[] = $meta['name'];
        }
        
        return $columns ?: null;
    }

    public function getByUserId($userId)
    {
        return $this->getByFields(array('userId' => $userId));
    }

    public function declares()
    {
        return array(
                'conditions' => array(
                'id = :id',
                'name = :name',
                'userId = :userId',
            ),
        );
    }
}