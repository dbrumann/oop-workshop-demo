<?php

namespace App\Product;

use App\Entity\Product;

class ProductBuilder
{
    private ProductDto $dto;

    public function __construct(
        private readonly ProductFactory $productFactory,
    ) {
        $this->reset();
    }

    public function reset(): self
    {
        $this->dto = new ProductDto();

        return $this;
    }

    public function withName(string $name): self
    {
        $this->dto->name = $name;

        return $this;
    }

    public function withDescription(string $description): self
    {
        $this->dto->description = $description;

        return $this;
    }

    public function withAmount(int $amount): self
    {
        $this->dto->amount = $amount;

        return $this;
    }

    public function withCurrency(string $currency): self
    {
        $this->dto->currency = $currency;

        return $this;
    }

    public function build(): Product
    {
        return $this->productFactory->create($this->dto);
    }
}