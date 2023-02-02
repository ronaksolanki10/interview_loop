<?php

namespace App\Repositories;

use App\Interfaces\Order as OrderInterface;
use Illuminate\Database\QueryException;
use App\Models\Order as OrderModel;

class Order implements OrderInterface
{
    private OrderModel $model;

    public function __construct(OrderModel $model)
    {
        $this->model =  $model;
    }
    public function get(array $where, string $sortBy, string $sortDir, int $page, int $limit): array
    {
        try {
            $offset = ($page - 1) * $limit;
            $query = $this->model->with(['products.product']);
            if (!empty($where)) {
                foreach($where as $conditon) {
                    $query = $query->where($conditon['column'], $conditon['operator'], $conditon['value']);
                }
            }
            $recordsFound = $query->count();
            $query = $query->orderBy($sortBy, $sortDir)->offset($offset)->take($limit)->get();
            return [
                'recordsTotal' => $recordsFound,
                'records' => $query
            ];
        } catch (QueryException $th) {
            throw $th;
        }
        
    }
    public function find(int $id): mixed
    {
        $record = $this->model->with(['products.product'])->where('id', $id)->first();
        
        return $record;
    }
    public function create(array $insertableData): void
    {
        $this->model->create($insertableData);
    }
    public function delete(int $id): void
    {
        $this->model->where('id', $id)->delete();
    }
    public function update(int $id, array $updatableData): void
    {
        $this->model->where('id', $id)->update($updatableData);
    }
}