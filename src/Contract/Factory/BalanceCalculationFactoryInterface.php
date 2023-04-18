<?php
declare(strict_types=1);

namespace Contract\Factory;

use Contract\Type\TransactionType;
use Contract\BalanceCalculation\BalanceCalculationInterface;

interface BalanceCalculationFactoryInterface
{
    public function create(TransactionType $transactionType): BalanceCalculationInterface;
}