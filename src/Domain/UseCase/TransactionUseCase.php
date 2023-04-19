<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Domain\UseCase;

use Serega170584\CleanArchitecture\Contract\Factory\BalanceCalculationFactoryInterface;
use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use Serega170584\CleanArchitecture\Contract\UseCase\TransactionUseCaseInterface;
use Serega170584\CleanArchitecture\Contract\Model\Transaction as TransactionModel;

final class TransactionUseCase implements TransactionUseCaseInterface
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
