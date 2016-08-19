<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolkit;
use AppBundle\Common\Paginator;
use AppBundle\Controller\UserBaseController;

class LeaderController extends UserBaseController
{
    public function listPresentAction(Request $request)
    {
        $conditions = $request->query->all();
        $conditions['status'] = 'on';
        $conditions['departmentId'] = $this->getUser()['departmentId'];

        $list = $this->listUsers($conditions);

        return $this->render('AppBundle:Leader:list/list-user.html.twig', array(
            'status' => 'on',
            'users' => $list['users'],
            'paginator' => $list['paginator']
        ));
    }

    public function listDemissionAction(Request $request)
    {
        $conditions = $request->query->all();
        $conditions['departmentId'] = $this->getUser()['departmentId'];
        $conditions['status'] = 'off';

        $list = $this->listUsers($conditions);

        return $this->render('AppBundle:Leader:list/list-user.html.twig', array(
            'status' => 'off',
            'users' => $list['users'],
            'paginator' => $list['paginator']
        ));
    }

    public function showAction(Request $request, $id)
    {   
        $basic = $this->getUserService()->getBasic($id);
        $familyMembers = $this->getUserService()->findFamilyMembers($basic['id']);
        $eduExperiences = $this->getUserService()->findEduExperiences($basic['id']);
        $workInfos = $this->getUserService()->findWorkExperiences($basic['id']);
        $otherInfo = $this->getUserService()->getOtherInfoByUserId($basic['id']);

        return $this->render('AppBundle:Leader:show/show-user-info.html.twig', array(
            'basic' => $basic,
            'familyMembers' => $familyMembers,
            'eduExperiences' => $eduExperiences,
            'workInfos' => $workInfos,
            'otherInfo' => $otherInfo,
            'tab' => 'basic',
        ));
    }
}