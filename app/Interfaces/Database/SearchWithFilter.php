<?php

namespace App\Interfaces\Database;

interface SearchWithFilter
{
    public function searchWithFilter(array $where, string $sortBy, string $sortDir, int $page, int $limit): array;
}