<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserWorkInfoDao extends GeneralDaoInterface
{
    public function findWorkExperiences($userId);

    public function getTableFields();
}