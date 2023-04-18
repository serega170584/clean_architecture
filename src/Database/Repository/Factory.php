<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Repository;

use Serega170584\CleanArchitecture\Source\SourceInterface;

final class Factory
{
    /**
     * @throws \Exception
     */
    public function create(string $modelName, SourceInterface $source): RepositoryInterface
    {
        $className = $modelName . 'Repository';
        if (!class_exists($className)) {
            throw new ClassNotFoundException("Class $className not found!");
        }
        return new $className($source);
    }
}
