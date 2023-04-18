<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Domain\Validator;

use Serega170584\CleanArchitecture\Contract\Exception\EmptyTransferAccountException;
use Serega170584\CleanArchitecture\Contract\Model\Account;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use Serega170584\CleanArchitecture\Contract\Validator\TransactionValidatorInterface;

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