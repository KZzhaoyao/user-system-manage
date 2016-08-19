<?php

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserSearchDao;
use Biz\User\Dao\Impl\UserSearchDaoImpl;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserSearchDaoImpl extends GeneralDaoImpl implements UserSearchDao
{
    public function searchAll($conditions, $orderBy, $start, $limit)
    {
        $mysql = '';
        if (isset($conditions['searchTime'])) {
            $timeType = $conditions['searchTime'];
            unset($conditions['searchTime']);
        }
        foreach ($conditions as $key => $value) {
            if ($key == 'startTime')
            {
                $mysql .= "{$value} <= {$timeType} AND ";
            } elseif ($key == 'endTime') {
                $mysql .= "{$value} >= {$timeType} AND ";
            } elseif ($key == 'trueName') {
                $mysql .= $key .' LIKE ' .'\'' .'%' .$value .'%' .'\'' .' AND ';
            } else {
                $mysql .= $key .'=\'' .$value .'\'' .' AND ';
            }
        }
        $mysql = rtrim($mysql,' AND ');
        
        $sql = "SELECT * FROM user_basic INNER JOIN department ON user_basic.departmentId = department.id INNER JOIN user ON user.id = user_basic.userId WHERE {$mysql} AND number > 0 ORDER BY {$orderBy[0]} {$orderBy[1]} LIMIT {$start},{$limit}";
        return $this->db()->fetchAll($sql) ?: array();
    }

    public function searchDepartmentUsers($conditions, $orderBy, $start, $limit)
    {   
        $mysql = '';
        foreach ($conditions as $key => $value) {
            if ($key == 'trueName')
            {
                $mysql .= $key .' LIKE ' .'\'' .'%' .$value .'%' .'\'' .' AND ';
            } else {
                $mysql .= $key .'=\'' .$value .'\'' .' AND ';
            }
        }
        $mysql = rtrim($mysql,' AND ');

        $sql = "SELECT * FROM user_basic INNER JOIN department ON user_basic.departmentId = department.id INNER JOIN user ON user.id = user_basic.userId WHERE {$mysql} AND number > 0 ORDER BY {$orderBy[0]} {$orderBy[1]} LIMIT {$start},{$limit}";
        
        return $this->db()->fetchAll($sql) ?: array();
    }

    public function searchAllCounts($conditions)
    {
        $mysql = '';
        if (isset($conditions['searchTime'])) {
            $timeType = $conditions['searchTime'];
            unset($conditions['searchTime']);
        }
        foreach ($conditions as $key => $value) {
            if ($key == 'startTime')
            {
                $mysql .= "{$value} <= {$timeType} AND ";
            } elseif ($key == 'endTime') {
                $mysql .= "{$value} >= {$timeType} AND ";
            } elseif ($key == 'trueName') {
                $mysql .= $key .' LIKE ' .'\'' .'%' .$value .'%' .'\'' .' AND ';
            } else {
                $mysql .= $key .'=\'' .$value .'\'' .' AND ';
            }
        }
        $mysql = rtrim($mysql,' AND ');
        $sql = "SELECT COUNT(*) FROM user_basic INNER JOIN department ON user_basic.departmentId = department.id INNER JOIN user ON user.id = user_basic.userId WHERE {$mysql} AND number > 0";
            $userCount = $this->db()->fetchAll($sql) ?: array();
            return $userCount[0]['COUNT(*)'];
    }

    public function searchDepartmentUserCounts($conditions)
    {
        $mysql = '';
        foreach ($conditions as $key => $value) {
            if ($key == 'trueName')
            {
                $mysql .= $key .' LIKE ' .'\'' .'%' .$value .'%' .'\'' .' AND ';
            } else {
                $mysql .= $key .'=\'' .$value .'\'' .' AND ';
            }
        }
        $mysql = rtrim($mysql,' AND ');

        $sql = "SELECT COUNT(*) FROM user_basic INNER JOIN department ON user_basic.departmentId = department.id INNER JOIN user ON user.id = user_basic.userId WHERE {$mysql} AND number > 0";
            $userCount = $this->db()->fetchAll($sql) ?: array();
            return $userCount[0]['COUNT(*)'];
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime', 'updatedTime'),
            'conditions' => array(
                'id = :id',
                'status = :status',
                'number = :number',
            ),
        );
    }
}