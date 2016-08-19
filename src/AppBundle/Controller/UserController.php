<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Common\ArrayToolkit;
use AppBundle\Common\Import;
use AppBundle\Common\Paginator;
use AppBundle\Controller\UserBaseController;

class UserController extends UserBaseController
{
    public function listPresentAction(Request $request)
    {
        $conditions = $request->query->all();
        $conditions['status'] = 'on';

        $list = $this->listUsers($conditions);

        $departmentsChoices = $this->getDepartmentChoices();

        return $this->render('AppBundle:User:list/list-user.html.twig',array(
            'status' => 'on',
            'users' => $list['users'],
            'paginator' => $list['paginator'],
            'departmentsChoices' => $departmentsChoices
        ));
    }


    public function showAction(Request $request, $id)
    {
        $basic = $this->getUserService()->getBasic($id);
        $familyMembers = $this->getUserService()->findFamilyMembers($basic['id']);
        $eduExperiences = $this->getUserService()->findEduExperiences($basic['id']);
        $workInfos = $this->getUserService()->findWorkExperiences($basic['id']);
        $otherInfo = $this->getUserService()->getOtherInfoByUserId($basic['id']);

        return $this->render('AppBundle:User:show/show-user-info.html.twig', array(
            'basic' => $basic,
            'familyMembers' => $familyMembers,
            'eduExperiences' => $eduExperiences,
            'workInfos' => $workInfos,
            'otherInfo' => $otherInfo,
            'tab' => 'basic',
        ));
    }

    public function editPersonAction(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();

            $this->getUserService()->update($id, $fields);        
        }

        $userData = $this->getUserService()->getCompleteData($id);

        $departmentsChoices = $this->getDepartmentChoices();

        return $this->render('AppBundle:User:edit/edit-user.html.twig', array(
            'user' => $userData['user'],
            'basic' => $userData['basic'],
            'familyMembers' => $userData['familyMembers'],
            'eduExperiences' => $userData['eduExperiences'],
            'workInfos' => $userData['workInfos'],
            'otherInfo' => $userData['otherInfo'],
            'extraInfo' => array(
                'nav' => 'edit_person',
            ),
            'departmentsChoices' => $departmentsChoices
        ));
    }

    public function uploadImagesAction(Request $request, $id, $type)
    {
        if ($request->getMethod() == 'POST') {
            $image = $request->files->get('image');
            $path = $this->getUserService()->uploadImage($id, $image, $type);

            return $this->render('AppBundle:User:upload/upload-images.html.twig', array(
                'imagePath' => $path,
                'id' => $id,
                'type' => $type
            ));
        }

        $user = $this->getUserService()->getUser($id);
        $path = $user['img'.$type];
        if (empty($path)) {
            $path = 'assets/avatar.png';
        }

        return $this->render('AppBundle:User:upload/upload-images.html.twig', array(
            'imagePath' => $path,
            'id' => $user['id'],
            'type' => $type
        ));
    }

    public function downloadAction(Request $request, $fileName)
    {
        $currentUser = $this->getUser();
        $path = $currentUser[$fileName];

        if ($fileName == 'imgEducation') {
            $fileName = '学历证书';
        } elseif($fileName == 'imgRank') {
            $fileName = '职称证书';
        } else {
            $fileName = '身份证';
        }
        if (!file_exists($path)) {
            throw new NotFoundHttpException('文件找不到');
        } else {
            $file = fopen($path, "r");       
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize($path));
            Header("Content-Disposition: attachment; filename=" . $fileName);
            echo fread($file,filesize($path));
            fclose($file);
            return new JsonResponse(true);
        }
    }
}
