<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\BalanceCalculation;

use Serega170584\CleanArchitecture\Contract\Model\Account;

interface BalanceCalculationInterface
{
    public function calculateBalance(Account $account, int $amount): void;
}
