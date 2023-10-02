<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Price\PriceFactory;
use App\Product\ProductDto;
use App\Product\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly ProductFactory $productFactory,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $productDto = new ProductDto();
        $productDto->name = 'Elephpant - small';
        $productDto->description = 'The famous PHP mascot as plushie in a compact form factor';
        $productDto->amount = 2999;
        $productDto->currency = 'EUR';

        $product = $this->productFactory->create($productDto);

        $manager->persist($product);
        $manager->flush();
    }
}
