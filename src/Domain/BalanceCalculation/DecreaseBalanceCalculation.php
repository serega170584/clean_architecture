<?php
declare(strict_types=1);

namespace Domain\BalanceCalculation;

use Contract\BalanceCalculation\BalanceCalculationInterface;
use Contract\Exception\NegativeBalanceException;
use Contract\Model\Account;

class DecreaseBalanceCalculation implements BalanceCalculationInterface
{
    /**
     * @throws NegativeBalanceException
     */
    public function calculateBalance(Account $account, int $amount): void
    {
        $balance = $account->getBalance();
        $balance -= $amount;

        if ($balance < 0) {
            throw new NegativeBalanceException(sprintf('account_id %s, current balance %s, amount %d', $account->getId(), $account->getBalance(), $amount));
        }

        $account->setBalance($balance);
    }
}