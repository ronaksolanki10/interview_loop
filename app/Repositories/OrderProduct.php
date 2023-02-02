<?php

namespace App\Repositories;

use App\Interfaces\OrderProduct as OrderProductInterface;
use App\Models\OrderProduct as OrderProductModel;
use Illuminate\Database\Events\QueryExecuted;

class OrderProduct implements OrderProductInterface
{
    private OrderProductModel $model;

    public function __construct(OrderProductModel $model)
    {
        $this->model =  $model;
    }
    public function create(array $insertableData): void
    {
        $this->model->create($insertableData);
    }
    public function delete(int $id): void
    {
        $this->model->where('id', $id)->delete();
    }
    public function findWhere(array $where): mixed
    {
        try {
            $query = $this->model;
            if (!empty($where)) {
                foreach($where as $conditon) {
                    $query = $query->where($conditon['column'], $conditon['operator'], $conditon['value']);
                }
            }

            return $query->first();
        } catch (QueryExecuted $th) {
            throw $th;
        }
    }
    public function exists(array $where): bool
    {
        try {
            $query = $this->model;
            if (!empty($where)) {
                foreach($where as $conditon) {
                    $query = $query->where($conditon['column'], $conditon['operator'], $conditon['value']);
                }
            }

            return $query->exists();
        } catch (QueryExecuted $th) {
            throw $th;
        }
    }
}