<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\Serializer;

interface SerializerInterface
{
    /**
     * @throws \Exception
     */
    public function serialize($unSerializedValue): string;

    /**
     * @throws \Exception
     */
    public function unSerialize(string $serializedValue): object;
}
