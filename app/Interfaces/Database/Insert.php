<?php

namespace App\Interfaces\Database;

interface Insert
{
    public function insert(array $insertableData): void;
}