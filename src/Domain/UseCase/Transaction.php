<?php
declare(strict_types=1);

namespace Domain\UseCase;

use Contract\Factory\BalanceCalculationFactoryInterface;
use Contract\Model\Account;
use Contract\Type\TransactionType;
use Contract\UseCase\TransactionInterface;
use Contract\Model\Transaction as TransactionModel;

final class Transaction implements TransactionInterface
{
    private BalanceCalculationFactoryInterface $balanceCalculationFactory;

    public function __construct(BalanceCalculationFactoryInterface $balanceCalculationFactory)
    {
        $this->balanceCalculationFactory = $balanceCalculationFactory;
    }

    public function operate(Account $account, int $amount, TransactionType $type, string $comment = '', ?Account $toAccount = null): TransactionModel
    {
        $balanceAlgoritm = $this->balanceCalculationFactory->create($type);
        $balanceAlgoritm->calculateBalance($account, $amount);

        if (TransactionType::TRANSFER === $type) {
            $balance = $toAccount->getBalance();
            $toAccount->setBalance($balance + $amount);
        }

        $transaction = new TransactionModel();
        $transaction->setComment($comment);
        $transaction->setAccount($account);
        $transaction->setToAccount($toAccount);
        $transaction->setAmount($amount);
        $transaction->setDueDate(new \DateTimeImmutable());
        $transaction->setType($type);
        return $transaction;
    }
}