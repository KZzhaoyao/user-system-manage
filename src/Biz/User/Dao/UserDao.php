<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserDao extends GeneralDaoInterface
{	
	public function getJoinTime($userId);

    public function findByStatus($status);

    public function getTableFields();

    public function getByUsername($username);
}