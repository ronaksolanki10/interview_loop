<?php

namespace App\Interfaces\Database;

interface Create
{
    public function create(array $insertableData): void;
}