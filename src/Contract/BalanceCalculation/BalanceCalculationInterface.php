<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\BalanceCalculation;

use Serega170584\CleanArchitecture\Contract\Exception\NegativeBalanceException;
use Serega170584\CleanArchitecture\Contract\Model\Account;

interface BalanceCalculationInterface
{
    /**
     * @throws NegativeBalanceException
     */
    public function calculateBalance(Account $account, int $amount): void;
}
