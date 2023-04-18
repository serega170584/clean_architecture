<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\Factory;

use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use Serega170584\CleanArchitecture\Contract\BalanceCalculation\BalanceCalculationInterface;

interface BalanceCalculationFactoryInterface
{
    public function create(TransactionType $transactionType): BalanceCalculationInterface;
}