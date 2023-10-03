<?php

namespace App\Price;

interface CurrencyFactoryInterface
{
    public function create(): Currency;
}