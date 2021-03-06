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
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError(); 

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername(); 

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername, 
            'controller_name' => 'Connexion',
            'error' => $error, 
        ));
    }
}
