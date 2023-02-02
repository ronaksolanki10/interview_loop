<?php

namespace App\Interfaces\Database;

interface Exists
{
    public function exists(array $where): bool;
}