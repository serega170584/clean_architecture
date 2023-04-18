<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Handler;

interface HandlerInterface
{
    public function operateTransaction(int $accountId, int $count, string $type): void;
}
