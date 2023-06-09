<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Domain\BalanceCalculation;

use Serega170584\CleanArchitecture\Contract\BalanceCalculation\BalanceCalculationInterface;
use Serega170584\CleanArchitecture\Contract\Model\Account;

class IncreaseBalanceCalculation implements BalanceCalculationInterface
{
    public function calculateBalance(Account $account, int $amount): void
    {
        $balance = $account->getBalance();
        $balance += $amount;
        $account->setBalance($balance);
    }
}
