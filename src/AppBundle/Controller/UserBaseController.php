<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolkit;
use AppBundle\Common\Paginator;

class UserBaseController extends BaseController
{
    protected function listUsers($conditions)
    {
        $conditions = $this->arrayFilter($conditions);
        $pageNum = 20;
        if (isset($conditions['pageNum'])) {
            $pageNum = $conditions['pageNum'];
            unset($conditions['pageNum']);
        }
        
        $userCount = $this->getUserService()->searchAllUserCounts($conditions);
        $paginator = new Paginator(
            $this->get('request'),
            $userCount,
            $pageNum
        );

        $users = $this->getUserService()->searchAllUsers(
            $conditions,
            array('number', 'ASC'),
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        return array('users'=>$users, 'paginator'=>$paginator);
    }

    protected function arrayFilter($conditions)
    {
        $conditions = array_filter($conditions);
        if (!isset($conditions['startTime']) && !isset($conditions['endTime']) ) {
            unset($conditions['searchTime']);
        } 

        if (isset($conditions['startTime'])) {
            $conditions['startTime'] = strtotime($conditions['startTime']);
        }

        if (isset($conditions['endTime'])) {
            $conditions['endTime'] = strtotime($conditions['endTime']);
        }

        if (isset($conditions['page'])) {
            unset($conditions['page']);
        }

        if (!isset($conditions['keyword'])) {
            unset($conditions['key']);
        } else {
            $conditions[$conditions['key']] = $conditions['keyword'];
            unset($conditions['key']);
            unset($conditions['keyword']);
        }
        
        return $conditions;
    }

    protected function getDepartmentChoices()
    {
        $departments = $this->getDepartmentService()->findDepartments();
        $departmentsChoices = array();
        foreach ($departments as $department) {
            $departmentsChoices[$department['id']] = $department['name'];   
        }

        return $departmentsChoices;
    }

    protected function getDepartmentService()
    {
        return $this->biz['department_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }
}