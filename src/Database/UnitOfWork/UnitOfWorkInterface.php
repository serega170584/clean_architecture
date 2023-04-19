<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Database\UnitOfWork;

interface UnitOfWorkInterface
{
    public function start(): void;

    public function commit(): void;

    public function save(object $model): void;
}
