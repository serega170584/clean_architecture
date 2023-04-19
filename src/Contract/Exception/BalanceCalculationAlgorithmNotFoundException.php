<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\Exception;

use Throwable;

class BalanceCalculationAlgorithmNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'balance calculation algorithm error');
        parent::__construct($message, $code, $previous);
    }
}
