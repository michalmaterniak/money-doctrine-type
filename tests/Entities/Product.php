<?php

namespace Test\MoneyDoctrine\Entities;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(length: 500)]
    protected string $name = '';

    #[ORM\Embedded(class: Money::class, columnPrefix: 'price_')]
    protected Money $price;

    public function getId(): int
    {
        return $this->id ?? 0;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): static
    {
        $this->price = $price;

        return $this;
    }
}
