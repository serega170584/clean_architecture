<?php
declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Repository;

interface RepositoryInterface
{
    public function getAll(array $sort = []): array;
}