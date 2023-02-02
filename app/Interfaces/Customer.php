<?php

namespace App\Interfaces;

use App\Interfaces\Database\Create;
use App\Interfaces\Database\FindByEmail;

interface Customer extends Create, FindByEmail
{
}