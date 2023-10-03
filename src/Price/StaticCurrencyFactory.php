<?php

namespace App\Price;

class StaticCurrencyFactory implements CurrencyFactoryInterface
{
    private readonly ?Currency $cache;

    public function __construct(
        private readonly string $code
    ) {}

    public function create(): Currency
    {
        return $this->cache ?? $this->cache = new Currency($this->code);
    }
}