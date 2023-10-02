<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Elephpant - small');
        $product->setDescription('The famous PHP mascot as plushie in a compact form factor');
        $product->setAmount(2499);
        $product->setCurrency('EUR');

        $manager->persist($product);
        $manager->flush();
    }
}
