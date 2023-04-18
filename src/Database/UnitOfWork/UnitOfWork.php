<?php
declare(strict_types=1);

namespace Database\Manager;

use Source\SourceInterface;

class UnitOfWork implements UnitOfWorkInterface
{
    private SourceInterface $source;

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function start(): void
    {
        $this->source->startTransaction();
    }

    public function commit(): void
    {
        $this->source->endTransaction();
    }

    public function save(object $model): void
    {
        $this->source->save($model);
    }
}