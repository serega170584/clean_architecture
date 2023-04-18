<?php
declare(strict_types=1);

namespace Contract\Exception;

use Throwable;

class TransactionTypeNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'transaction type not found');
        parent::__construct($message, $code, $previous);
    }
}