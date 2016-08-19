<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolkit;

class DepartmentController extends BaseController
{
    public function listAction()
    {
        $departments = $this->getDepartmentService()->findDepartments();

        return $this->render('AppBundle:Department:list.html.twig',array(
            'departments' => $departments
        ));
    }

    public function createAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();
            $department = $this->getDepartmentService()->createDepartment($fields);
            if (empty($department)) {
                return new JsonResponse(false);
            }

            return new JsonResponse(true);
        }

        return $this->render('AppBundle:Department:add-modal.html.twig');
    }

    public function deleteAction(Request $request, $id)
    {   
        $department = $this->getDepartmentService()->deleteDepartment($id);
        if (!$department){
            return new JsonResponse(false);
        }

        return new JsonResponse(true);
    }

    public function editAction(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            $fields = $request->request->all();
            $updateDepartment = $this->getDepartmentService()->updateDepartment($id, $fields);
            if (empty($updateDepartment)){
                return new JsonResponse(false);
            }
            
            return new JsonResponse(true);
        }

        $department = $this->getDepartmentService()->getDepartment($id);

        return $this->render('AppBundle:Department:edit-modal.html.twig', array(
            'department' => $department,
            'id' => $id,
        ));  
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