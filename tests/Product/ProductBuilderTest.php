<?php

namespace App\Tests\Product;

use App\Price\PriceFactory;
use App\Product\ProductBuilder;
use App\Product\ProductFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductBuilderTest extends KernelTestCase
{
    public function testBuildsProduct(): void
    {
        $builder = new ProductBuilder(new ProductFactory(new PriceFactory('USD')));
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

    public function testBuilderFromContainerIsNotShared(): void
    {
        $this->markTestSkipped('Bonus Task: How can we make sure our builder is not reused?');

        self::bootKernel();

        $builder = self::getContainer()->get(ProductBuilder::class);
        $builder
            ->withName('My built product')
            ->withDescription('Product generated through the builder')
            ->withAmount(1323)
            ->withCurrency('EUR')
            ->build();

        $builder = self::getContainer()->get(ProductBuilder::class);

        $this->expectException(\Error::class);

        $builder->build();
    }
}
