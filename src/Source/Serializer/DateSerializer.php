<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\Serializer;

use Serega170584\CleanArchitecture\Source\Exception\InvalidDateField;

class DateSerializer implements SerializerInterface
{
    /**
     * @throws InvalidDateField
     */
    public function serialize($unSerializedValue): string
    {
        if (!$unSerializedValue instanceof \DateTimeImmutable) {
            throw new InvalidDateField(sprintf('%s', $unSerializedValue));
        }

        /**
         * @var \DateTimeImmutable $date
         */
        return $date->format('Y-m-d');
    }

    public function unSerialize(string $serializedValue): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d', $serializedValue);
    }
}
