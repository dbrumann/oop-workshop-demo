<?php

namespace App\Tests\Price;

use App\Price\StaticCurrencyFactory;
use PHPUnit\Framework\TestCase;

class CurrencyFactoryTest extends TestCase
{
    public function testCreatesCurrency(): void
    {
        $factory = new StaticCurrencyFactory('EUR');

        self::assertSame('EUR', (string) $factory->create());
    }

    public function testCreatedCurrencyIsSingleton(): void
    {
        $factory = new StaticCurrencyFactory('EUR');

        self::assertSame($factory->create(), $factory->create());
    }
}
