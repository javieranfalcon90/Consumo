<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    /**
     * @Route("/seguridad/login", name="usuario_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils){

        $error = $authenticationUtils->getLastAuthenticationError();

        $msg = '';
        $msg_type = '';
        if($error){
            $msg = 'Usuario y/o contraseña incorrectos';
            $msg_type = 'danger';
        }

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', array(
            'last_username' => $lastUsername,
            'msg' => $msg,
            'msg_type' => $msg_type
        ));

    }

    /**
     * @Route("/seguridad/logout", name="usuario_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
