<?php

namespace App\Helpers;

interface Api
{
    public function get($endpoint): mixed;
}