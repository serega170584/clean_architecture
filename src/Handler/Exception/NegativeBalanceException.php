<?php
declare(strict_types=1);

namespace Handler\Exception;

use Throwable;

class NegativeBalanceException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'negative account balance');
        parent::__construct($message, $code, $previous);
    }
}