<?php

namespace App\Price;

use App\Entity\Price;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class PriceFactory
{
    public function __construct(
        private readonly CurrencyLocator $currencyLocator,
        #[Autowire(value: 'EUR')]
        private readonly string $defaultCurrencyCode,
    ) {}

    public function create(int $amount, string $currency = null): Price
    {
        return new Price(
            amount: $amount,
            currency: $this->currencyLocator->get($currency ?? $this->defaultCurrencyCode)
        );
    }
}