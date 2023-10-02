<?php

namespace App\Tests\Product;

use App\Price\PriceFactory;
use App\Product\ProductDto;
use App\Product\ProductFactory;
use PHPUnit\Framework\TestCase;

class ProductFactoryTest extends TestCase
{
    public function testCreatesProductFromDto(): void
    {
        $productFactory = new ProductFactory(new PriceFactory('EUR'));
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
