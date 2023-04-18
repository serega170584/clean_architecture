<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Repository;

use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Source\SourceInterface;
use Serega170584\CleanArchitecture\Contract\Model\Transaction;

final class TransactionRepository implements RepositoryInterface
{
    private SourceInterface $source;

    private AccountRepository $accountRepository;

    private array $data;

    public function __construct(SourceInterface $source, AccountRepository $accountRepository)
    {
        $this->source = $source;
        $this->accountRepository = $accountRepository;
    }

    public function getOne(int $id): Transaction
    {
        $transaction = $this->data[$id] ?? null;
        if (null === $transaction) {
            $data = $this->source->findById(Transaction::class, $id);
            $transaction = new Transaction();
            $accountId = $data['account_id'];
            $account = $this->accountRepository->getOne($accountId);
            $transaction->setAccount($account);
            $transaction->setType($data['type']);
            $transaction->setAmount($data['amount']);
            $transaction->setComment($data['comment']);
            $transaction->setId($data['id']);
            $this->data[$id] = $transaction;
        }
        return $transaction;
    }

    public function getAll(array $sort = []): array
    {
        $data = $this->source->query(Account::class, [], $sort);
        $this->data = $data;
        return $data;
    }

    public function getSortedByDueDate(): array
    {
        return $this->getAll(['dueDate' => 'ASC']);
    }

    public function getSortedByComment(): array
    {
        return $this->getAll(['comment' => 'ASC']);
    }
}
