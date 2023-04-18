<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\FieldAdapter;

interface SerializerInterface
{
    public function serialize(object $model): string;

    public function unSerialize(string $value): object;
}