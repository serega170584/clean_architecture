<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\Type;

enum TransactionType: string
{
    case DEPOSIT = 'D';
    case WITHDRAW = 'W';
    case TRANSFER = 'T';
}
