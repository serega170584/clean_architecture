<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\Validator;

use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;

interface TransactionValidatorInterface
{
    public function validate(Account $account, int $count, TransactionType $type, ?Account $toAccount = null): void;
}