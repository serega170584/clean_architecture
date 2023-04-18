<?php
declare(strict_types=1);

namespace Domain\BalanceCalculation;

use Contract\BalanceCalculation\BalanceCalculationInterface;
use Contract\Model\Account;

class IncreaseBalanceCalculation implements BalanceCalculationInterface
{
    public function calculateBalance(Account $account, int $count): void
    {
        $balance = $account->getBalance();
        $balance += $count;
        $account->setBalance($balance);
    }
}