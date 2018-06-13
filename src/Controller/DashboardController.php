<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
    	$securityContext = $this->container->get('security.authorization_checker');
		if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			$token = $this->get('security.token_storage')->getToken();
			$user = $token->getUser();
		  	print_r($user);
		}

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'Dashboard',
        ]);
    }
}
