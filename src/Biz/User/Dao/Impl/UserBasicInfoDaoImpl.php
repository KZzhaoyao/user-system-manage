<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserBasicInfoDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserBasicInfoDaoImpl extends GeneralDaoImpl implements UserBasicInfoDao
{
    protected $table = 'user_basic';

    public function findBasicInfoByIds($ids)
    {
        $sql = "SELECT * FROM $this->table WHERE id IN $ids";
        return $this->db()->fetchAll($sql) ?: array();
    }

    public function getByUserId($userId)
    {
        return $this->getByFields(array('userId' => $userId));
    }

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

    public function declares()
    {
        return array(
            'conditions' => array(
                'id = :id',
                'name = :name',
                'department = :department'
            ),
        );
    }
}