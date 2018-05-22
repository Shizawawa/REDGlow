<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
    * @Route("/security", name="security")
    */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
    * @Route("/login", name="login")
    */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError(); 

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername(); 

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername, 
            'controller_name' => 'SecurityController',
            'error' => $error, 
        ));
    }

    /**
    * @Route("/register", name="register")
    */
    public function register(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError(); 

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername(); 

        return $this->render('security/register.html.twig', array(
            'last_username' => $lastUsername, 
            'controller_name' => 'SecurityController',
            'error' => $error, 
        ));
    }
}
