<?php

declare(strict_types=1);

namespace Serega170584\CleanArchitecture\Database\Repository;

interface RepositoryInterface
{
    public function getAll(array $sort = []): array;
}
