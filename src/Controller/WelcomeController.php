<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\WelcomeRepository; 
use App\Entity\Welcome; 

class WelcomeController extends Controller
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function index()
    {
    	$welcomeRepo = $this->getDoctrine()->getRepository(Welcome::class); 

    	$welcomes = $welcomeRepo->findAll(); 

    	return $this->render('welcome/index.html.twig', [
			'controller_name' => 'WelcomeController',
			'welcomes'        => $welcomes, 
        ]);
    }
}
