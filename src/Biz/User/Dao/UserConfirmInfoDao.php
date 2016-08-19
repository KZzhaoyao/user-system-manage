<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserConfirmInfoDao extends GeneralDaoInterface
{
    public function getTableFields();
}