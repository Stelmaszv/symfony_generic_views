<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Cars;
class Car extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Cars();
        $manager->persist($product);
        $manager->flush();
    }
}
