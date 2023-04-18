<?php
declare(strict_types=1);

namespace Contract\UseCase;

use Contract\Exception\NegativeBalanceException;
use Contract\Model\Account;
use Contract\Model\Transaction;
use Contract\Type\TransactionType;

interface TransactionInterface
{
    /**
     * @throws NegativeBalanceException
     */
    public function operate(Account $account, int $amount, TransactionType $type, string $comment = '', ?Account $toAccount = null): Transaction;
}