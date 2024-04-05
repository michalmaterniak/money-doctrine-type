<?php

namespace Test\MoneyDoctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use MoneyDoctrine\Money as BaseMoney;

#[ORM\Embeddable]
readonly class Money extends BaseMoney
{}