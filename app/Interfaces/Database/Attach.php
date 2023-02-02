<?php

namespace App\Interfaces\Database;

interface Attach
{
    public function attach(int $id, array $insertableData): void;
}