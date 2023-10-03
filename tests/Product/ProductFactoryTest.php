<?php

namespace App\Tests\Product;

use App\Price\CurrencyLocator;
use App\Price\PriceFactory;
use App\Price\StaticCurrencyFactory;
use App\Product\ProductDto;
use App\Product\ProductFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ProductFactoryTest extends TestCase
{
    public function testCreatesProductFromDto(): void
    {
        $container = new ContainerBuilder();
        $container->set('app.price.price_factory.eur', new StaticCurrencyFactory('EUR'));
        $container->set('app.price.price_factory.usd', new StaticCurrencyFactory('USD'));
        $productFactory = new ProductFactory(new PriceFactory(new CurrencyLocator($container), 'EUR'));
        $dto = new ProductDto();
        $dto->name = 'Test';
        $dto->description = 'This is a factory test.';
        $dto->amount = 2342;
        $dto->currency = 'EUR';

        $product = $productFactory->create($dto);

        self::assertSame($dto->name, $product->getName());
        self::assertSame($dto->description, $product->getDescription());
        self::assertSame($dto->amount, $product->getPrice()->getAmount());
        self::assertSame($dto->currency, (string) $product->getPrice()->getCurrency());
    }
}
