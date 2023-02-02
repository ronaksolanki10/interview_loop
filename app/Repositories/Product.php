<?php

namespace App\Repositories;

use App\Interfaces\Product as ProductInterface;
use App\Models\Product as ProductModel;

class Product implements ProductInterface
{
    private ProductModel $model;

    public function __construct(ProductModel $model)
    {
        $this->model =  $model;
    }
    public function create(array $insertableData): void
    {
        $this->model->create($insertableData);
    }
}