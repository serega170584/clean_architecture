<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\Exception;

use Throwable;

class FileldIsBlockedForUpdate extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'field is blocked for update');
        parent::__construct($message, $code, $previous);
    }
}