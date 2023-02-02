<?php

namespace App\Interfaces\Services;

use App\Http\Requests\Orders\AttachProduct;
use App\Http\Requests\Orders\DeAttachProduct;
use App\Http\Requests\Orders\Index;
use App\Http\Requests\Orders\Store;

interface Order
{
    public function get(Index $request): array;
    public function create(Store $request): void;
    public function find(int $id): mixed;
    public function delete(int $id): void;
    public function attachProduct(int $id, AttachProduct $request): array;
    public function DeAttachProduct(int $id, DeAttachProduct $request): array;
    public function pay(int $id): array;
}