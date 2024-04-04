<?php

declare(strict_types=1);

namespace MoneyDoctrine\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Money\Currency\Currency;

final class CurrencyType extends Type
{
    public const NAME = 'currency';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof Currency) {
            return $value->getCode();
        }

        throw new ConversionException();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Currency
    {
        return new Currency($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}

