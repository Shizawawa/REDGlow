<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendrierController extends Controller
{
    /**
     * @Route("/calendrier", name="calendrier")
     */
    public function index()
    {
        return $this->render('calendrier/index.html.twig', [
            'controller_name' => 'CalendrierController',
        ]);
    }
}
