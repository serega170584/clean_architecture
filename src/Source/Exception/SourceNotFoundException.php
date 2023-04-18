<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\Exception;

use Throwable;

class SourceNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'source not found');
        parent::__construct($message, $code, $previous);
    }
}
