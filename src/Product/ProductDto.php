<?php

namespace App\Product;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{
    #[Assert\Length(min: 2, max: 100)]
    public string $name;

    #[Assert\Length(min: 5)]
    public string $description;

    #[Assert\PositiveOrZero()]
    public int $amount;

    #[Assert\Choice(choices: ['EUR', 'USD'])]
    public string $currency;
}