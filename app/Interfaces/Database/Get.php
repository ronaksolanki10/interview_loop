<?php

namespace App\Interfaces\Database;

interface Get
{
    public function get(array $where, string $sortBy, string $sortDir, int $page, int $limit): array;
}