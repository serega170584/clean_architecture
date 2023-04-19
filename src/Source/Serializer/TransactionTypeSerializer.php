<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\Serializer;

use Serega170584\CleanArchitecture\Contract\Exception\TransactionTypeNotFoundException;
use Serega170584\CleanArchitecture\Contract\Type\TransactionType;
use Serega170584\CleanArchitecture\Source\Exception\InvalidDateField;
use Serega170584\CleanArchitecture\Source\Exception\InvalidModelException;

class TransactionTypeSerializer implements SerializerInterface
{
    /**
     * @throws InvalidModelException
     * @throws InvalidDateField
     * @throws TransactionTypeNotFoundException
     */
    public function serialize($unSerializedValue): string
    {
        /**
         * @var TransactionType $unSerializedValue
         */
        return $unSerializedValue->value;
    }

    /**
     * @throws TransactionTypeNotFoundException
     */
    public function unSerialize(string $serializedValue): TransactionType
    {
        try {
            $transactionType = TransactionType::from($serializedValue);
        } catch (\Error $e) {
            throw new TransactionTypeNotFoundException($e->getMessage());
        }

        return $transactionType;
    }
}