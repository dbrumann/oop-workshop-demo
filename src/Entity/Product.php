<?php

namespace App\Entity;

use App\Price\Currency;
use App\Price\CurrencyFactory;
use App\Price\Price;
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

    #[ORM\Column(name: 'amount', type: 'integer')]
    private int $amount;

    #[ORM\Column(name: 'currency', type: 'string', length: 4)]
    private string $currency;

    public function __construct(string $name, string $description, Price $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->amount = $price->getAmount();
        $this->currency = (string) $price->getCurrency();
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
        return new Price($this->amount, CurrencyFactory::new($this->currency));
    }
}