<?php

namespace App\Interfaces\Database;

interface Delete
{
    public function delete(int $id): void;
}