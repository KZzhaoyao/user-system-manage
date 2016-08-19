<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserFamilyInfoDao extends GeneralDaoInterface
{
    public function findFamilyMembers($userId);
 
    public function getTableFields();
}