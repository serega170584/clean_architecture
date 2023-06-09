<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source;

use Serega170584\CleanArchitecture\Source\Serializer\SerializerInterface;

interface SourceInterface
{
    public function startTransaction(): void;

    public function endTransaction(): void;

    public function query(string $sourceName, array $filter = [], array $sort = []): array;

    public function findById(string $class, int $id, bool $isBlockForUpdate): array;

    public function save(object $model): void;

    public function addFieldSerializer(string $schemaName, string $field, SerializerInterface $serializer): void;
}
