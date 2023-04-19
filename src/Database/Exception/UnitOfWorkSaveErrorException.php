<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Database\Exception;

use Throwable;

class UnitOfWorkSaveErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'unit of work save error');
        parent::__construct($message, $code, $previous);
    }
}
