<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Domain\Factory;

use Serega170584\CleanArchitecture\Contract\BalanceCalculation\BalanceCalculationInterface;
use Serega170584\CleanArchitecture\Contract\Exception\BalanceCalculationAlgorithmNotFoundException;
use Serega170584\CleanArchitecture\Contract\Factory\BalanceCalculationFactoryInterface;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use Serega170584\CleanArchitecture\Domain\BalanceCalculation\DecreaseBalanceCalculation;
use Serega170584\CleanArchitecture\Domain\BalanceCalculation\IncreaseBalanceCalculation;

class BalanceCalculationFactory implements BalanceCalculationFactoryInterface
{
    /**
     * @throws BalanceCalculationAlgorithmNotFoundException
     */
    public function create(TransactionType $transactionType): BalanceCalculationInterface
    {
        $algorithmClassName = match ($transactionType) {
            TransactionType::TRANSFER, TransactionType::WITHDRAW => IncreaseBalanceCalculation::class,
            TransactionType::DEPOSIT => DecreaseBalanceCalculation::class
        };

        if (null === $algorithmClassName) {
            throw new BalanceCalculationAlgorithmNotFoundException();
        }

        return new $algorithmClassName();
    }
}
