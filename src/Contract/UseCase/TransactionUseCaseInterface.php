<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\UseCase;

use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Contract\Model\Transaction;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;

interface TransactionUseCaseInterface
{
    public function operate(Account $account, int $amount, TransactionType $type, string $comment = '', ?Account $toAccount = null): Transaction;
}
