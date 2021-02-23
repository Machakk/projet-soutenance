<?php

namespace App\DataFixtures;

use App\Entity\Metiers;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $metier = new Metiers();
        $metier2 = new Metiers();
        $metier3 = new Metiers();

        $metier->setMetier('Frontend');
        $manager->persist($metier);
        $manager->flush();

        $metier2->setMetier('Backend');
        $manager->persist($metier2);
        $manager->flush();

        $metier3->setMetier('Design');
        $manager->persist($metier3);

        $manager->flush();
    }
}
