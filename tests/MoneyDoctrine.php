<?php

namespace Test\MoneyDoctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use MoneyDoctrine\Doctrine\Type\CurrencyType;
use MoneyDoctrine\Doctrine\Type\MoneyType;
use PHPUnit\Framework\TestCase;

abstract class MoneyDoctrine extends TestCase
{
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__."/Entities"),
            isDevMode: true,
        );

        $dsnParser = new DsnParser();
        $connectionParams = $dsnParser->parse('pdo-sqlite:///:memory:');

        $conn = DriverManager::getConnection($connectionParams);
        try {
            $conn->beginTransaction();
            $conn->executeQuery("CREATE TABLE products (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(10) NOT NULL, price_currency VARCHAR(3) NOT NULL, price_amount INT NOT NULL)");
            $conn->executeQuery("INSERT INTO products (name, price_currency, price_amount) VALUES ('test4', 'USD', 1000), ('name1', 'USD', 986),('name2', 'USD', 368),('name2', 'USD', 432),('name3', 'EUR', 567)");
            $conn->commit();

            if (!Type::hasType('money')) {
                Type::addType('money', MoneyType::class);
            }

            if (!Type::hasType('currency')) {
                Type::addType('currency', CurrencyType::class);
            }
        } catch (\Throwable $e) {
            $this->fail('Failure during setUp MoneyDoctrineTest');
        }
        $this->entityManager = new EntityManager($conn, $config);
    }
}