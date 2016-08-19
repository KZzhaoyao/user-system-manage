<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserConfirmInfoDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserConfirmInfoDaoImpl extends GeneralDaoImpl implements UserConfirmInfoDao
{
    protected $table = 'confirm_person';

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
            ),
        );
    }
}