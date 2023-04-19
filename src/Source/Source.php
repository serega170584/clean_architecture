<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source;

use Serega170584\CleanArchitecture\Source\Exception\FieldNotFoundException;
use Serega170584\CleanArchitecture\Source\Exception\FileldIsBlockedForUpdate;
use Serega170584\CleanArchitecture\Source\Exception\SchemaNotFoundException;
use Serega170584\CleanArchitecture\Source\Exception\SortTypeNotFoundException;
use Serega170584\CleanArchitecture\Source\Exception\SourceNotFoundException;
use Serega170584\CleanArchitecture\Source\Serializer\SerializerInterface;

class Source implements SourceInterface
{
    private const SORT_ASC = 'ASC';
    private const SORT_DESC = 'DESC';
    private const SORT = [self::SORT_ASC, self::SORT_DESC];

    private $isBlockedForUpdate = [
        'Serega170584\CleanArchitecture\Contract\Model\Account' => [],
        'Serega170584\CleanArchitecture\Contract\Model\Transaction' => []
    ];

    private array $data = [
        'Serega170584\CleanArchitecture\Contract\Model\Account' => [
            1 => [
                'id' => 1,
                'name' => 'Test',
                'balance' => 5000
            ],
            2 => [
                'id' => 2,
                'name' => 'Test Test',
                'balance' => 6000
            ]
        ],
        'Serega170584\CleanArchitecture\Contract\Model\Transaction' => [
            1 => [
                'id' => 1,
                'type' => 'D',
                'comment' => 'Test deposit',
                'amount' => 1000,
                'dueDate' => '2023-01-01'
            ],
            2 => [
                'id' => 2,
                'type' => 'W',
                'comment' => 'Test withdraw ',
                'amount' => 1000,
                'dueDate' => '2022-01-01'
            ],
            3 => [
                'id' => 3,
                'type' => 'T',
                'comment' => 'Test transfer',
                'amount' => 1000,
                'dueDate' => '2021-01-01'
            ],
        ],
        'schema' => [
            'Serega170584\CleanArchitecture\Contract\Model\Account' => ['id', 'name', 'balance'],
            'Serega170584\CleanArchitecture\Contract\Model\Transaction' => ['id', 'type', 'comment', 'amount', 'dueDate']
        ],
        'next_id' => [
            'Serega170584\CleanArchitecture\Contract\Model\Account' => 3,
            'Serega170584\CleanArchitecture\Contract\Model\Transaction' => 4
        ]
    ];

    private array $transactionData = [
        'next_id' => [
            'Serega170584\CleanArchitecture\Contract\Model\Account' => 3,
            'Serega170584\CleanArchitecture\Contract\Model\Transaction' => 4
        ]
    ];

    private array $serializerFieldData = [];

    public function startTransaction(): void
    {
    }

    /**
     * @throws SourceNotFoundException
     * @throws FieldNotFoundException
     * @throws SortTypeNotFoundException
     * @throws \Exception
     */
    public function query(string $sourceName, array $filter = [], array $sort = []): array
    {
        $sourceData = $this->data[$sourceName] ?? null;
        if (null === $sourceData) {
            throw new SourceNotFoundException(sprintf("%s", $sourceName));
        }

        $schema = $this->data['schema'][$sourceName];
        $filterFields = array_keys($filter);
        $diff = array_diff($filterFields, $schema);

        if ([] !== $diff) {
            throw new FieldNotFoundException(sprintf('%s', implode(' ', $diff)));
        }

        $result = $this->getFilteredResult($sourceData, $filter);

        $sortKey = array_keys($sort)[0] ?? null;
        $sortValue = array_values($sort)[0] ?? null;

        $isDiff = false;
        if (null !== $sortKey) {
            $isDiff = !in_array($sortKey, $schema);
        }

        if ($isDiff) {
            throw new FieldNotFoundException(sprintf('sorted field %s', $sortKey));
        }

        $isDiff = false;
        if (null !== $sortValue) {
            $isDiff = !in_array($sortValue, self::SORT);
        }

        if ($isDiff) {
            throw new SortTypeNotFoundException(sprintf('%s', $sortValue));
        }

        if (null !== $sortKey) {
            $result = $this->getSortedResult($result, $sortKey, $sortValue);
        }

        return $this->transformData($sourceName, $result);
    }

    /**
     * @throws \Exception
     */
    private function transformData(string $sourceName, array $sourceData): array
    {
        $result = [];
        foreach ($sourceData as $row) {
            $model = new $sourceName();
            foreach ($row as $fieldKey => $fieldValue) {
                $method = 'set' . ucfirst($fieldKey);
                /**
                 * @var SerializerInterface $fieldSerializer
                 */
                $fieldSerializer = $this->serializerFieldData[$sourceName][$fieldKey] ?? null;
                if (null === $fieldSerializer) {
                    $model->$method($fieldValue);
                    continue;
                }
                $model->$method($fieldSerializer->unSerialize($fieldValue));
            }
            $result[$model->getId()] = $model;
        }
        return $result;
    }

    private function getSortedResult(array $result, string $sortKey, string $sortValue): array
    {
        $keyValues = array_column($result, $sortKey);

        $keyMapResult = [];
        foreach ($result as $item) {
            $keyMapResult[$item[$sortKey]][] = $item;
        }

        if (self::SORT_ASC === $sortValue) {
            sort($keyValues);
        } else {
            rsort($keyValues);
        }

        $tmpResult = [];
        foreach ($keyValues as $keyValue) {
            $mapResult = $keyMapResult[$keyValue];
            foreach ($mapResult as $item) {
                $tmpResult[$item['id']] = $item;
            }
        }

        return $tmpResult;
    }

    private function getFilteredResult(array $sourceData, array $filter = []): array
    {
        if ([] === $filter) {
            return $sourceData;
        }

        $result = [];
        foreach ($sourceData as $key => $data) {
            $isDiff = false;
            foreach ($filter as $filterKey => $filterVal) {
                if ($data[$filterKey] !== $filterVal) {
                    $isDiff = true;
                    break;
                }
            }

            if (!$isDiff) {
                $result[$key] = $data;
            }
        }
        return $result;
    }

    public function endTransaction(): void
    {
        foreach ($this->transactionData as $field => $data) {
            if ('schema' !== $field) {
                $this->data[$field] = $this->transactionData[$field] + $this->data[$field];
            }
        }

        $this->isBlockedForUpdate = [];
        $this->transactionData = [];
    }

    /**
     * @throws SourceNotFoundException
     * @throws FileldIsBlockedForUpdate
     */
    public function findById(string $class, int $id, bool $isBlockForUpdate = false): array
    {
        $data = $this->data[$class] ?? null;
        if (null === $class) {
            throw new SourceNotFoundException();
        }

        if ($isBlockForUpdate && in_array($id, $this->isBlockedForUpdate[$class])) {
            throw new FileldIsBlockedForUpdate();
        }

        if ($isBlockForUpdate) {
            $this->isBlockedForUpdate[] = $id;
        }

        return $data[$id];
    }

    /**
     * @throws SourceNotFoundException
     * @throws \Exception
     */
    public function save(object $model): void
    {
        $class = get_class($model);
        $isClassExisted = $this->data[$class] ?? false;

        if (false === $isClassExisted) {
            throw new SourceNotFoundException();
        }

        $id = $model->getId();
        if (null === $id) {
            $id = $this->transactionData['next_id'][$class];
            ++$this->transactionData['next_id'][$class];
            $model->setId($id);
        }

        $schema = $this->data['schema'][$class];
        $data = [];
        foreach ($schema as $field) {
            $method = 'get' . ucfirst($field);
            $value = $model->$method();
            /**
             * @var SerializerInterface $fieldSerializer
             */
            $fieldSerializer = $this->serializerFieldData[$class][$field] ?? null;
            if (null !== $fieldSerializer) {
                $value = $fieldSerializer->serialize($value);
            }
            $data[$field] = $value;
        }

        $this->transactionData[$class][$id] = $data;
    }

    /**
     * @throws SchemaNotFoundException
     * @throws FieldNotFoundException
     */
    public function addFieldSerializer(string $schemaName, string $field, SerializerInterface $serializer): void
    {
        $isSchemaExisted = $this->data['schema'][$schemaName] ?? false;
        if (!$isSchemaExisted) {
            throw new SchemaNotFoundException(sprintf('%s', $schemaName));
        }

        $isFieldExisted = in_array($field, $this->data['schema'][$schemaName]);
        if (!$isFieldExisted) {
            throw new FieldNotFoundException(sprintf('schema: %s, field: %s ', $schemaName, $field));
        }

        $this->serializerFieldData[$schemaName][$field] = $serializer;
    }
}
