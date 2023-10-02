<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'store_products')]
class Product
{
    #[ORM\Column(name: 'id', type: 'integer', options: ['unsigned' => true])]
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private readonly int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 100)]
    #[Assert\Length(min: 2, max: 100)]
    private string $name;

    #[ORM\Column(name: 'description', type: 'text')]
    #[Assert\Length(min: 5)]
    private string $description;

    #[ORM\Column(name: 'amount', type: 'integer')]
    #[Assert\PositiveOrZero()]
    private int $amount;

    #[ORM\Column(name: 'currency', type: 'string', length: 4)]
    #[Assert\Choice(choices: ['EUR', 'USD'])]
    private string $currency;

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

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }
}