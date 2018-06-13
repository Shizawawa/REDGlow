<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Welcome;

class WelcomeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $welcome = new Welcome();
        $welcome->setName('WelcomeRachel'); 
        $manager->persist($welcome);
        $manager->flush();

        /*$welcome = new Welcome();
        $welcome->setName('WelcomeToto'); 
        $manager->persist($welcome);
        $manager->flush();*/
    }
}
