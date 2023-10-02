<?php

namespace App\Price;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class PriceFactory
{
    public function __construct(
        #[Autowire(value: 'EUR')]
        private readonly string $defaultCurrencyCode,
    ) {}

    public function create(int $amount, string $currency = null): Price
    {
        return new Price(
            amount: $amount,
            currency: CurrencyFactory::new($currency ?? $this->defaultCurrencyCode)
        );
    }
}