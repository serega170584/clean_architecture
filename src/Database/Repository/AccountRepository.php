<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Database\Repository;

use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Source\SourceInterface;

final class AccountRepository implements RepositoryInterface
{
    private SourceInterface $source;

    private array $data = [];

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function getOne(int $id, bool $isBlockForUpdate = false): ?Account
    {
        $account = $this->data[$id] ?? null;
        if (null === $account) {
            $data = $this->source->findById(Account::class, $id, $isBlockForUpdate = false);
            $account = new Account();
            $account->setId($data['id']);
            $account->setBalance($data['balance']);
            $account->setName($data['name']);
            $this->data[$id] = $account;
        }
        return $account;
    }

    public function getAll(array $sort = []): array
    {
        $data = $this->source->query(Account::class, [], $sort);
        $this->data = $data;
        return $data;
    }
}
