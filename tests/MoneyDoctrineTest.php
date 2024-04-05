<?php

namespace Test\MoneyDoctrine;

use MoneyDoctrine\Doctrine\Money\Amount;
use MoneyDoctrine\Doctrine\Money\Currency;
use Test\MoneyDoctrine\Entities\Money;
use Test\MoneyDoctrine\Entities\Product;

class MoneyDoctrineTest extends MoneyDoctrine
{
    public function testReadMoneyDoctrine(): void
    {
        $product = $this->entityManager->getRepository(Product::class)->find(1);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertInstanceOf(Money::class, $product->getPrice());
    }

    public function testWriteMoneyDoctrine(): void
    {
        try {
            $price = new Money(new Amount(100), new Currency('PLN'));
            $product = new Product();
            $product->setName('product123');
            $product->setPrice($price);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->assertIsInt($product->getId());
            $this->assertSame(6, $product->getId());
        } catch (\Throwable $e) {
            $this->fail('Failure');
        }
    }

    public function testSearchByMoneyDoctrine(): void
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->select('products')
            ->from(Product::class, 'products')
            ->andWhere('products.price.amount = :amount')
            ->andWhere('products.price.currency = :currency')
            ->setParameter('amount', 368)
            ->setParameter('currency', 'USD')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        $this->assertInstanceOf(Product::class, $result);
        $this->assertInstanceOf(Money::class, $result->getPrice());
        $this->assertSame(3, $result->getId());
    }
}