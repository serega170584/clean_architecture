<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Handler;

use Serega170584\CleanArchitecture\Contract\Exception\TransactionTypeNotFoundException;
use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use Serega170584\CleanArchitecture\Contract\UseCase\TransactionUseCaseInterface;
use Serega170584\CleanArchitecture\Contract\Validator\TransactionValidatorInterface;
use Serega170584\CleanArchitecture\Database\UnitOfWork\UnitOfWorkInterface;
use Serega170584\CleanArchitecture\Handler\Exception\AccountNotFoundException;
use Serega170584\CleanArchitecture\Handler\Exception\TransactionValidatorErrorException;
use Serega170584\CleanArchitecture\Handler\Exception\TransactionOperationException;
use Serega170584\CleanArchitecture\Database\Repository\AccountRepository;
use Serega170584\CleanArchitecture\Database\Repository\TransactionRepository;

class Handler
{
    private AccountRepository $accountRepository;

    private TransactionUseCaseInterface $transaction;

    private TransactionValidatorInterface $transactionValidator;

    private TransactionRepository $transactionRepository;

    private UnitOfWorkInterface $unitOfWork;

    public function __construct(AccountRepository $accountRepository, TransactionRepository $transactionRepository, TransactionUseCaseInterface $transaction, TransactionValidatorInterface $transactionValidator, UnitOfWorkInterface $unitOfWork)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transaction = $transaction;
        $this->transactionValidator = $transactionValidator;
        $this->unitOfWork = $unitOfWork;
    }

    public function getAllAccounts(): array
    {
        return $this->accountRepository->getAll();
    }

    public function getAccountBalance(Account $account): int
    {
        return $account->getBalance();
    }

    /**
     * @throws AccountNotFoundException
     * @throws TransactionTypeNotFoundException
     * @throws TransactionValidatorErrorException|TransactionOperationException
     */
    public function operateTransaction(int $accountId, int $count, string $type, string $comment = '', ?int $toAccountId = null): void
    {
        $unitOfWork = $this->unitOfWork;
        $unitOfWork->start();

        $account = $this->accountRepository->getOne($accountId, true);

        if (null === $account) {
            throw new AccountNotFoundException((string)$accountId);
        }

        try {
            $transactionType = TransactionType::from($type);
        } catch (\Error $e) {
            throw new TransactionTypeNotFoundException($e->getMessage());
        }

        $toAccount = null;
        if (null !== $toAccountId) {
            $toAccount = $this->accountRepository->getOne($toAccountId, true);
        }

        try {
            $this->transactionValidator->validate($account, $count, $transactionType, $toAccount);
        } catch (\Exception $e) {
            throw new TransactionValidatorErrorException($e->getMessage());
        }

        try {
            $transaction = $this->transaction->operate($account, $count, $transactionType, $comment, $toAccount);
        } catch (\Exception $e) {
            throw new TransactionOperationException($e->getMessage());
        }

        $unitOfWork->save($account);

        if (null !== $toAccount) {
            $unitOfWork->save($toAccount);
        }
        $unitOfWork->save($transaction);

        $unitOfWork->commit();
    }
}
