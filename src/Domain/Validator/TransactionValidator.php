<?php
declare(strict_types=1);

namespace Domain\Validator;

use Contract\Exception\EmptyTransferAccountException;
use Contract\Model\Account;
use Contract\Type\TransactionType;
use Contract\Validator\TransactionValidatorInterface;

class TransactionValidator implements TransactionValidatorInterface
{
    /**
     * @throws EmptyTransferAccountException
     */
    public function validate(Account $account, int $count, TransactionType $type, ?Account $toAccount = null): void
    {
        if (TransactionType::TRANSFER === $type && null === $toAccount) {
            throw new EmptyTransferAccountException();
        }
    }
}