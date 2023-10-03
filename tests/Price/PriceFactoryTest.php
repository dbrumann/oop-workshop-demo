<?php

namespace App\Tests\Price;

use App\Price\CurrencyLocator;
use App\Price\PriceFactory;
use App\Price\StaticCurrencyFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PriceFactoryTest extends KernelTestCase
{
    private PriceFactory $priceFactory;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->priceFactory = static::getContainer()->get(PriceFactory::class);
    }

    public function testCreatesPriceFromAmount(): void
    {
        $price = $this->priceFactory->create(1999);

        self::assertSame(1999, $price->getAmount());
        self::assertSame('EUR', (string) $price->getCurrency());
    }

    public function testCurrencyOverwritesDefault(): void
    {
        $container = new ContainerBuilder();
        $container->set('app.price.price_factory.eur', new StaticCurrencyFactory('EUR'));
        $container->set('app.price.price_factory.usd', new StaticCurrencyFactory('USD'));

        $priceFactory = new PriceFactory(new CurrencyLocator($container), 'EUR');

        $price = $priceFactory->create(1999, 'USD');

        self::assertSame(1999, $price->getAmount());
        self::assertSame('USD', (string) $price->getCurrency());
    }
}
