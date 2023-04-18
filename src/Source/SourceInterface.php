<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source;

use Serega170584\CleanArchitecture\Source\FieldAdapter\SerializerInterface;

interface SourceInterface
{
    public function startTransaction(): void;
    
    public function endTransaction(): void;
    
    public function query(string $sourceName, array $filter = [], array $sort = []): array;

    public function findById(string $class, int $id, bool $isBlockForUpdate): object;

    public function save(object $model): void;

    public function addFieldSerializer(string $modelName, string $field, SerializerInterface $serializer): void;
}