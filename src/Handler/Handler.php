<?php
declare(strict_types=1);

namespace Handler;

use Contract\Exception\EmptyTransferAccountException as ContractEmptyTransferAccountException;
use Contract\Exception\NegativeBalanceException as ContractNegativeBalanceException;
use Contract\Exception\TransactionTypeNotFoundException;
use Contract\Model\Account;
use Contract\Type\TransactionType;
use Contract\UseCase\TransactionInterface;
use Database\Manager\UnitOfWork;
use Domain\Validator\TransactionValidator;
use Handler\Exception\AccountNotFoundException;
use Handler\Exception\EmptyTransferAccountException;
use Handler\Exception\NegativeBalanceException;
use Repository\AccountRepository;
use Repository\TransactionRepository;
use Source\SourceInterface;

class Handler implements HandlerInterface
{
    private AccountRepository $accountRepository;

    private TransactionInterface $transaction;

    private SourceInterface $source;

    private TransactionValidator $transactionValidator;

    private TransactionRepository $transactionRepository;

    public function __construct(AccountRepository $accountRepository, TransactionRepository $transactionRepository, TransactionInterface $transaction, SourceInterface $source, TransactionValidator $transactionValidator)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transaction = $transaction;
        $this->source = $source;
        $this->transactionValidator = $transactionValidator;
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
     * @throws EmptyTransferAccountException
     * @throws NegativeBalanceException
     */
    public function operateTransaction(int $accountId, int $count, string $type, string $comment = '', ?int $toAccountId = null): void
    {
        $unitOfWork = new UnitOfWork($this->source);
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
        } catch (ContractEmptyTransferAccountException $e) {
            throw new EmptyTransferAccountException($e->getMessage());
        }

        try {
            $transaction = $this->transaction->operate($account, $count, $transactionType, $comment, $toAccount);
        } catch (ContractNegativeBalanceException $e) {
            throw new NegativeBalanceException($e->getMessage());
        }

        $unitOfWork->save($account);
        $unitOfWork->save($toAccount);
        $unitOfWork->save($transaction);

        $unitOfWork->commit();
    }

    public function getTransactionsSortedByComment(): array
    {
        return $this->transactionRepository->getAll(['comment' => 'ASC']);
    }

    public function getTransactionsSortedByDueDate(): array
    {
        return $this->transactionRepository->getAll(['dueDate' => 'ASC']);
    }
}