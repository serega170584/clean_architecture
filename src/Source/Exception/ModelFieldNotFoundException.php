<?php
declare(strict_types=1);

namespace Source\Exception;

use Throwable;

class ModelFieldNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf("%s - $message", 'model field not found');
        parent::__construct($message, $code, $previous);
    }
}