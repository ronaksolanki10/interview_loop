<?php

namespace App\Interfaces;

use App\Interfaces\Database\Create;
use App\Interfaces\Database\Delete;
use App\Interfaces\Database\Exists;
use App\Interfaces\Database\FindWhere;

interface OrderProduct extends Create, Delete, Exists, FindWhere
{
}