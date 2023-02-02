<?php

namespace App\Interfaces\Database;

interface FindWhere
{
    public function findWhere(array $where): mixed;
}