<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\Model;

use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use DateTimeImmutable;

class Transaction
{
    private ?int $id = null;

    private TransactionType $type;

    private ?string $comment;

    private int $amount;

    private DateTimeImmutable $dueDate;

    private Account $account;

    private ?Account $toAccount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getType(): TransactionType
    {
        return $this->type;
    }

    public function setType(TransactionType $type): void
    {
        $this->type = $type;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getDueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function setDueDate(DateTimeImmutable $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public function getToAccount(): ?Account
    {
        return $this->toAccount;
    }

    public function setToAccount(?Account $toAccount): void
    {
        $this->toAccount = $toAccount;
    }
}
