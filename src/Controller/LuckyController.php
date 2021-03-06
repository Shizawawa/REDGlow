<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky", name="lucky")
     */
    public function number()
    {
    	$number = mt_rand(0, 100); 
    	return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}
