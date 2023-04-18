<?php
declare(strict_types=1);

namespace Repository;

interface RepositoryInterface
{
    public function getAll(array $sort = []): array;
}