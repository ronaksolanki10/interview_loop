<?php

namespace App\Repositories;

use App\Interfaces\Customer as CustomerInterface;
use App\Models\Customer as CustomerModel;
use stdClass;

class Customer implements CustomerInterface
{
    private CustomerModel $model;

    public function __construct(CustomerModel $model)
    {
        $this->model =  $model;
    }
    public function create(array $insertableData): void
    {
        $this->model->create($insertableData);
    }
    public function findByEmail(string $email): mixed
    {
        return $this->model->where('email', $email)->first();
    }
}