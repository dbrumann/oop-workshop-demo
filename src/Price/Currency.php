<?php

namespace App\Price;

use function Symfony\Component\String\u;

class Currency implements \Stringable
{
    private readonly string $code;

    public function __construct(string $code)
    {
        $this->code = u($code)->upper()->toUnicodeString();
    }

    public function __toString(): string
    {
        return $this->code;
    }
}