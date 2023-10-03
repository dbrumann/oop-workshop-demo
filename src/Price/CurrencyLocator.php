<?php

namespace App\Price;

use Psr\Container\ContainerInterface;

class CurrencyLocator
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {}

    public function get(string $code): Currency
    {
        $factory = $this->container->get(sprintf('app.price.price_factory.%s', strtolower($code)));
        if (!$factory instanceof CurrencyFactoryInterface) {
            throw new \InvalidArgumentException(sprintf('Could not create currency for code "%s". Invalid service type: "%s".', $code, get_debug_type($factory)));
        }

        return $factory->create();
    }
}