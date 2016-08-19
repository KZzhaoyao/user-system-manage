<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolkit;
use AppBundle\Common\Import;
use AppBundle\Common\Paginator;
use AppBundle\Controller\UserBaseController;

class AdminController extends UserBaseController
{
    public function createUserAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();

            $this->getUserService()->createUser($fields);
            
            return $this->redirect($this->generateUrl('admin_user_present_list'));
        }

        $departmentsChoices = $this->getDepartmentChoices();

        return $this->render('AppBundle:User:add/add-user.html.twig', array(
            'departmentsChoices' => $departmentsChoices
        ));        
    }

    public function editUserAction(Request $request, $id)
    {
        $userService = $this->getUserService();

        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();

            $userService->update($id, $fields);

            return $this->redirect($this->generateUrl('admin_user_present_list'));         
        }

        $userData = $userService->getCompleteData($id);

        $departmentsChoices = $this->getDepartmentChoices();

        return $this->render('AppBundle:User:edit/edit-user.html.twig', array(
            'user' => $userData['user'],
            'basic' => $userData['basic'],
            'familyMembers' => $userData['familyMembers'],
            'eduExperiences' => $userData['eduExperiences'],
            'workInfos' => $userData['workInfos'],
            'otherInfo' => $userData['otherInfo'],
            'extraInfo' => array(
                'nav' => 'edit_user',
            ),
            'departmentsChoices' => $departmentsChoices
        ));

    }

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

    public function listDemissionAction(Request $request)
    {
        $conditions = $request->query->all();
        $conditions['status'] = 'off';
        
        $list = $this->listUsers($conditions);

        $departmentsChoices = $this->getDepartmentChoices();
        
        return $this->render('AppBundle:User:list/list-user.html.twig',array(
            'status' => 'off',
            'users' => $list['users'],
            'paginator' => $list['paginator'],
            'departmentsChoices' => $departmentsChoices
        ));
    }

    public function downloadAction(Request $request, $id, $fileName)
    {
        $user = $this->getUserService()->getUser($id);
        $path = $user[$fileName];

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

    public function certificateAction(Request $request, $id, $type)
    {
        $user = $this->getUserService()->getUser($id);
        $basic = $this->getUserService()->getBasic($user['id']);
        $user['trueName'] = $basic['trueName'];

        return $this->render('AppBundle:User:show/certificate.html.twig', array(
            'user' => $user,
            'type' => $type
        ));
    }

    public function exitJobAction(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();

            $this->getUserService()->updateUser($id, array(
                'status' => 'off',
                'quitTime' => strtotime($fields['quitTime'])
            ));

            return new JsonResponse(array('userId'=>$id));
        }

        return $this->render('AppBundle:User:change-jobstatus-modal.html.twig', array(
            'id' => $id,
            'status' => 'on',
            'url' => 'admin_user_exit_job'
        ));
    }

    public function entryJobAction(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();

            $this->getUserService()->updateUser($id, array(
                'status' => 'on',
                'joinTime' => strtotime($fields['joinTime'])
            ));

            return new JsonResponse(array('userId'=>$id));
        }

        return $this->render('AppBundle:User:change-jobstatus-modal.html.twig', array(
            'id' => $id,
            'status' => 'off',
            'url' => 'admin_user_entry_job'
        ));
    }
    
    public function changeUserRoleAction(Request $request, $id)
    {
        if ($request->getMethod() =='POST') {
            $fields = $request->request->all();

            if (empty($fields['roles'])) {
                $fields['roles'] = array('ROLE_USER');
            }

            $roles = $this->getUserService()->updateUser($id, array('roles' => $fields['roles']));
            
            return new JsonResponse(true);
        }

        $user = $this->getUserService()->getUser($id);
        return $this->render('AppBundle:User:change-role-modal.html.twig', array(
            'user'=> $user,
        ));
    }

    public function checkNumberForCreateAction(Request $request)
    {
        $number = $request->query->get('number');
        $user = $this->getUserService()->getUserByNumber($number);
        if (empty($user)) {
            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }

    public function importAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $tmpFile = $_FILES['file_stu']['tmp_name'];
            $import = new Import();
            $users = $import->import($tmpFile);

            $this->getUserService()->importUsers($users);

            return $this->redirect($this->generateUrl('admin_user_present_list'));
        }

        return $this->render('AppBundle:User:import.html.twig');
    }

    
}
