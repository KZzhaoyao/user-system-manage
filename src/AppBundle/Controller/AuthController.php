<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends BaseController
{
    public function homepageAction(Request $request)
    {
        $currentUser = $this->getUser();

        if (empty($currentUser)) {
            return $this->redirect($this->generateUrl('login'));
        }
        
        if (count(array_intersect($currentUser['roles'], array('ROLE_ADMIN'))) > 0) {
            return $this->forward('AppBundle:Admin:listPresent');
        }

        return $this->forward('AppBundle:User:listPresent');
    }

    public function registerAction(Request $request)
    {
        if ('POST' == $request->getMethod()) {
            $user = $request->request->all();
            $user = $this->getUserService()->register($user);
            $this->login($user, $request);
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('AppBundle:Register:index.html.twig');
    }

    public function loginAction(Request $request)
    {        
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Auth:login.html.twig', array(
                'last_username' => $lastUsername,
                'error' => $error,
        ));
    }

    public function logoutAction(Request $request)
    {

    }

    public function checkAction(Request $request)
    {

    }
    
    protected function getUserService()
    {
        return $this->biz['user_service'];
    }
}