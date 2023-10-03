<?php

namespace App\Product;

use App\Entity\Product;
use App\Price\PriceFactory;
use function Symfony\Component\String\b;

class ProductFactory
{
    public function __construct(
        private readonly PriceFactory $priceFactory,
    ) {}

    public function create(ProductDto $dto): Product
    {
        return new Product(
            name: $dto->name,
            description: $dto->description,
            price: $this->priceFactory->create($dto->amount, $dto->currency)
        );
    }
}