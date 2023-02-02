<?php

namespace App\Interfaces\Database;

interface Update
{
    public function update(int $id, array $updatableData): void;
}