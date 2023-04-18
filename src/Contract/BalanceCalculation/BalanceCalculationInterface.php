<?php
declare(strict_types=1);

namespace Contract\BalanceCalculation;

use Contract\Exception\NegativeBalanceException;
use Contract\Model\Account;

interface BalanceCalculationInterface
{
    /**
     * @throws NegativeBalanceException
     */
    public function calculateBalance(Account $account, int $amount): void;
}