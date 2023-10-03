<?php

namespace App\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductCreatorFacade
{
    public function __construct(
        private readonly ProductValidator $validator,
        private readonly ProductFactory $productFactory,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function create(ProductDto $dto): Product
    {
        $this->validator->validate($dto);

        $product = $this->productFactory->create($dto);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->refresh($product);
        $this->entityManager->clear();

        return $product;
    }
}