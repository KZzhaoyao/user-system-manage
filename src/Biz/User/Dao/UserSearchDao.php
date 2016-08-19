<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserSearchDao extends GeneralDaoInterface
{
    public function searchAll($conditions, $orderBy, $start, $limit);

    public function searchDepartmentUsers($conditions, $orderBy, $start, $limit);

    public function searchAllCounts($conditions);

    public function searchDepartmentUserCounts($conditions);
}