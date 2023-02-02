<?php

namespace App\Interfaces\Database;

interface FindByEmail
{
    public function findByEmail(string $email): mixed;
}