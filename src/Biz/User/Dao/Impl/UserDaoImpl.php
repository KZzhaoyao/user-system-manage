<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserDao;
use Biz\User\Dao\Impl\UserDaoImpl;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserDaoImpl extends GeneralDaoImpl implements UserDao
{
    protected $table = 'user';

    public function findByStatus($status)
    {
        $sql = "SELECT * FROM $this->table WHERE status = {$status}";
        return $this->db()->fetchAll($sql) ?: array();
    }

    public function getByUsername($username)
    {
        return $this->getByFields(array('username' => $username));
    }

    public function getUserByNumber($number)
    {
        return $this->getByFields(array('number' => $number));
    }
    
    public function getJoinTime($userId)
    {
        $sql = "SELECT joinTime FROM {$this->table} WHERE id = ?";
        return $this->db()->fetchAssoc($sql,array($userId)) ?: array();
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
            'timestamps' => array('createdTime', 'updatedTime'),
            'serializes' => array('roles' => 'delimiter'),
            'conditions' => array(
                'id = :id',
                'status = :status',
                'number = :number', 
            ),
        );
    }
}