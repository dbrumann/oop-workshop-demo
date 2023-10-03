<?php

namespace App\Entity;

use App\Price\Currency;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Price
{
    #[Column(name: 'amount', type: 'integer')]
    private readonly int $amount;

    #[Column(name: 'currency', type: 'string', length: 4)]
    private readonly string $currency;

    public function __construct(int $amount, string|Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = (string) $currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return new Currency($this->currency);
    }
}