<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserBasicInfoDao extends GeneralDaoInterface
{
    public function findBasicInfoByIds($ids);

    public function getTableFields();

    public function getByUserId($userId);
}