<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Source\FieldAdapter;

use Serega170584\CleanArchitecture\Source\Exception\InvalidDateField;
use Serega170584\CleanArchitecture\Source\Exception\InvalidModelException;
use Serega170584\CleanArchitecture\Source\Exception\ModelFieldNotFoundException;

class DateSerializer implements  SerializerInterface
{
    private string $modelName;

    private string $field;

    /**
     * @throws ModelFieldNotFoundException
     */
    public function __construct(string $modelName, string $field)
    {
        $method = 'get' . ucfirst($field);
        if (!method_exists($modelName, $method)) {
            throw new ModelFieldNotFoundException(sprintf('model: %s, field: %s', $modelName, $field));
        }

        $this->modelName = $modelName;
        $this->field = $field;
    }

    /**
     * @throws InvalidModelException
     * @throws InvalidDateField
     */
    public function serialize(object $model): string
    {
        $method = 'get' . ucfirst($this->field);
        $modelClass = get_class($model);
        if ($modelClass !== $this->modelName) {
            throw new InvalidModelException(sprintf('model class: %s, model name: %s', $modelClass, $this->modelName));
        }

        $date = $model->$method();
        if (!$date instanceof \DateTimeImmutable) {
            throw new InvalidDateField(sprintf('model class: %s, method: %s', $modelClass, $method));
        }

        /**
         * @var \DateTimeImmutable $date
         */
        return $date->format('Y-m-d');
    }

    public function unSerialize(string $value): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d', $value);
    }
}