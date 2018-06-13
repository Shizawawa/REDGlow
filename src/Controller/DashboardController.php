<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
    	/*$securityContext = $this->container->get('security.authorization_checker');
		if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			$token = $this->get('security.token_storage')->getToken();
			$user = $token->getUser();
		  	print_r($user);
		}*/
		$securityContext = $this->container->get('security.authorization_checker');
		if (false === $securityContext->isGranted('ROLE_USER')) {
	        throw new AccessDeniedException('Unable to access this page!');
	    }
	    
	    $token = $this->get('security.token_storage')->getToken();
		$user = $token->getUser();
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'Dashboard',
            'user' => $user,
        ]);
    }
}
