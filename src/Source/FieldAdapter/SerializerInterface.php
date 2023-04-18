<?php
declare(strict_types=1);

namespace Source\FieldAdapter;

interface SerializerInterface
{
    public function serialize(object $model): string;

    public function unSerialize(string $value): object;
}