<?php

namespace Biz\User;

interface UserService
{
    /**
     * user表
     */
    public function createUser($user);

    public function importUsers($users);

    public function updateUser($id, $fields);

    public function getUser($id);

    public function register($user);

    public function getUserByUsername($userName);

    public function uploadImage($userId, $image, $type);
    
    public function getUserByNumber($number);

    /**
     * user_basic_info表
     */
    public function getBasic($userId);

    public function findDepartmentsCounts($departments);

    /**
     * user_family_info表
     */
    public function findFamilyMembers($userId);

    /**
     * user_learn_info表
     */
    public function findEduExperiences($userId);

    /**
     * user_work_info表
     */
    public function findWorkExperiences($userId);

    /**
     * user_other_info表
     */
    public function getOtherInfoByUserId($userId);

    public function searchAllUsers($conditions, $orderBy, $start, $limit);

    public function searchDepartmentUsers($conditions, $orderBy, $start, $limit);

    public function searchAllUserCounts($conditions);

    public function searchDepartmentUserCounts($conditions);
}