<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserFamilyInfoDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserFamilyInfoDaoImpl extends GeneralDaoImpl implements UserFamilyInfoDao
{
    protected $table = 'family_member';

    public function findFamilyMembers($userId)
    {   
        $sql = "SELECT * FROM {$this->table} WHERE userId = ?";     
        return $this->db()->fetchAll($sql, array($userId)) ?: array();
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

    public function deleteByUserId($userId)
    {
        return $this->db()->delete($this->table(), array('userId'=> $userId));
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