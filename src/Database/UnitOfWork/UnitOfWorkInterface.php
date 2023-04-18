<?php
declare(strict_types=1);

namespace Database\Manager;

interface UnitOfWorkInterface
{
    public function start(): void;

    public function commit(): void;

    public function save(object $model): void;
}