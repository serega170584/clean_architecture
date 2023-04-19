<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Database\UnitOfWork;

use Serega170584\CleanArchitecture\Database\Exception\UnitOfWorkSaveErrorException;
use Serega170584\CleanArchitecture\Source\SourceInterface;

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

    /**
     * @throws UnitOfWorkSaveErrorException
     */
    public function save(object $model): void
    {
        try {
            $this->source->save($model);
        } catch (\Exception $e) {
            throw new UnitOfWorkSaveErrorException($e->getMessage());
        }
    }
}
