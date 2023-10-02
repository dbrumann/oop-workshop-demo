<?php

namespace App\Tests\Price;

use App\Price\PriceFactory;
use PHPUnit\Framework\TestCase;

class PriceFactoryTest extends TestCase
{
    public function testCreatesPriceFromAmount(): void
    {
        $priceFactory = new PriceFactory('EUR');

        $price = $priceFactory->create(1999);

        self::assertSame(1999, $price->getAmount());
        self::assertSame('EUR', (string) $price->getCurrency());
    }

    public function testCurrencyOverwritesDefault(): void
    {
        $priceFactory = new PriceFactory('EUR');

        $price = $priceFactory->create(1999, 'USD');

        self::assertSame(1999, $price->getAmount());
        self::assertSame('USD', (string) $price->getCurrency());
    }
}
