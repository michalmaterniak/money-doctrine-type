<?php

namespace MoneyDoctrine;

use Doctrine\ORM\Mapping as ORM;
use Money\Amount\AmountInterface;
use Money\Currency\CurrencyInterface;
use Money\Money as BaseMoney;

#[ORM\Embeddable]
readonly class Money extends BaseMoney
{
    #[ORM\Column(type: 'money', nullable: false)]
    protected AmountInterface $amount;

    #[ORM\Column(type: 'currency', length: 3, nullable: false)]
    protected CurrencyInterface $currency;
}