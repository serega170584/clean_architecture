<?php
declare(strict_types=1);

namespace Handler;

interface HandlerInterface
{
    public function operateTransaction(int $accountId, int $count, string $type): void;
}