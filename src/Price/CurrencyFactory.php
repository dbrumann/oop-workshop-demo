<?php

namespace App\Price;

/**
 * @internal
 */
class CurrencyFactory
{
    private static array $instances = [];

    public static function new(string $code): Currency
    {
        if (array_key_exists(strtoupper($code), self::$instances)) {
            return self::$instances[strtoupper($code)];
        }

        $currency = \Closure::bind(
            static function (string $code): Currency {
                return new self($code);
            },
            null,
            Currency::class
        )($code);

        return self::$instances[strtoupper($code)] = $currency;
    }
}