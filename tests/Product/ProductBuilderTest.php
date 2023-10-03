<?php

namespace App\Tests\Product;

use App\Price\CurrencyLocator;
use App\Price\PriceFactory;
use App\Price\StaticCurrencyFactory;
use App\Product\ProductBuilder;
use App\Product\ProductFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ProductBuilderTest extends KernelTestCase
{
    public function testBuildsProduct(): void
    {
        $container = new ContainerBuilder();
        $container->set('app.price.price_factory.eur', new StaticCurrencyFactory('EUR'));
        $container->set('app.price.price_factory.usd', new StaticCurrencyFactory('USD'));
        $builder = new ProductBuilder(new ProductFactory(new PriceFactory(new CurrencyLocator($container), 'EUR')));
        $product = $builder
            ->withName('My built product')
            ->withDescription('Product generated through the builder')
            ->withAmount(1323)
            ->withCurrency('EUR')
            ->build();

        self::assertSame('My built product', $product->getName());
        self::assertSame('Product generated through the builder', $product->getDescription());
        self::assertSame(1323, $product->getPrice()->getAmount());
        self::assertSame('EUR', (string) $product->getPrice()->getCurrency());
    }

    public function testBuilderIsNeverInjectedAsService(): void
    {
        self::bootKernel();

        $this->expectException(ServiceNotFoundException::class);

        self::getContainer()->get(ProductBuilder::class);
    }
}
