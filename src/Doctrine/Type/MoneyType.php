<?php

declare(strict_types=1);

namespace MoneyDoctrine\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use MoneyDoctrine\Doctrine\Money\Amount;
use MoneyDoctrine\Doctrine\Money\AmountInterface;

final class MoneyType extends Type
{
    public const NAME = 'currency';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getBigIntTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof AmountInterface) {
            return $value->getAmount();
        }

        throw new ConversionException();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): AmountInterface
    {
        return new Amount($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}

