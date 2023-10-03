<?php

namespace App\Product;

use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {}

    public function validate(ProductDto $productDto): void
    {
        $errors = $this->validator->validate($productDto);

        if (count($errors) > 0) {
            throw new ValidationFailedException($productDto, $errors);
        }
    }
}