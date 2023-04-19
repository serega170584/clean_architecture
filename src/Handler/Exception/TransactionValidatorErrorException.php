<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Handler\Exception;

use Throwable;

class TransactionValidatorErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'transaction validator error');
        parent::__construct($message, $code, $previous);
    }
}
