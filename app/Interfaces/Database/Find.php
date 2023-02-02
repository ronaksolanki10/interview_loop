<?php

namespace App\Interfaces\Database;

interface Find
{
    public function find(int $id): mixed;
}