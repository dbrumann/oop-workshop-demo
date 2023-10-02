<?php

namespace App\Tests\Price;

use App\Price\CurrencyFactory;
use PHPUnit\Framework\TestCase;

class CurrencyFactoryTest extends TestCase
{
    public function testCreatesCurrency(): void
    {
        $currency = CurrencyFactory::new('EUR');

        self::assertSame('EUR', (string) $currency);
    }

    public function testCreatedCurrencyIsSingleton(): void
    {
        self::assertSame(CurrencyFactory::new('EUR'), CurrencyFactory::new('EUR'));
    }
}
