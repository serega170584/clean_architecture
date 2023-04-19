<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Database\Exception;

use Throwable;

class QueryException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'query error');
        parent::__construct($message, $code, $previous);
    }
}
