<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserLearnInfoDao extends GeneralDaoInterface
{
    public function findEduExperiences($userId);
    
    public function getTableFields();
}