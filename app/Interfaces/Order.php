<?php

namespace App\Interfaces;

use App\Interfaces\Database\Create;
use App\Interfaces\Database\Delete;
use App\Interfaces\Database\Find;
use App\Interfaces\Database\Get;
use App\Interfaces\Database\Update;

interface Order extends Get, Create, Find, Delete, Update
{
}