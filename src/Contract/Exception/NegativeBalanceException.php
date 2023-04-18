<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Contract\Exception;

use Throwable;

class NegativeBalanceException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'negative balance');
        parent::__construct($message, $code, $previous);
    }
}