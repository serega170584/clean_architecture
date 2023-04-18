<?php
declare(strict_types=1);

namespace Contract\Validator;

use Contract\Model\Account;
use Contract\Type\TransactionType;

interface TransactionValidatorInterface
{
    public function validate(Account $account, int $count, TransactionType $type, ?Account $toAccount = null): void;
}