<?php
declare(strict_types=1);

namespace Domain\Factory;

use Contract\BalanceCalculation\BalanceCalculationInterface;
use Contract\Factory\BalanceCalculationFactoryInterface;
use Contract\Type\TransactionType;
use Domain\BalanceCalculation\DecreaseBalanceCalculation;
use Domain\BalanceCalculation\IncreaseBalanceCalculation;

class BalanceCalculationFactory  implements BalanceCalculationFactoryInterface
{
    public function create(TransactionType $transactionType): BalanceCalculationInterface
    {
        $algorithmClassName = match ($transactionType) {
            TransactionType::TRANSFER, TransactionType::WITHDRAW => IncreaseBalanceCalculation::class,
            TransactionType::DEPOSIT => DecreaseBalanceCalculation::class
        };
        return new $algorithmClassName();
    }
}