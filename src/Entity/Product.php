<?php

namespace App\Entity;

use App\Price\Currency;
use App\Price\StaticCurrencyFactory;
use App\Entity\Price;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'store_products')]
class Product
{
    #[ORM\Column(name: 'id', type: 'integer', options: ['unsigned' => true])]
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private readonly int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 100)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'text')]
    private string $description;

    #[ORM\Embedded(class: Price::class, columnPrefix: false)]
    private Price $price;

    public function __construct(string $name, string $description, Price $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}