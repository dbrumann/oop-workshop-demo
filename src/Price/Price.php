<?php

namespace App\Price;

class Price
{
    public function __construct(
        private readonly int $amount,
        private readonly Currency $currency,
    ) {}

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}