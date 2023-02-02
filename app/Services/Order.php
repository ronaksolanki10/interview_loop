<?php

namespace App\Services;

use App\Http\Requests\Orders\AttachProduct;
use App\Http\Requests\Orders\DeAttachProduct;
use App\Http\Requests\Orders\Index;
use App\Http\Requests\Orders\Store;
use App\Http\Resources\Orders\Pay;
use App\Interfaces\Order as OrderInterface;
use App\Interfaces\OrderProduct as OrderProductInterface;
use App\Interfaces\Services\Order as OrderServiceInterface;
use Illuminate\Http\Response;

class Order implements OrderServiceInterface
{
    private OrderInterface $order;
    private OrderProductInterface $orderProduct;

    public function __construct(OrderInterface $order, OrderProductInterface $orderProduct)
    {
        $this->order = $order;
        $this->orderProduct = $orderProduct;
    }
    public function get(Index $request): array
    {
        $conditions = [];
        $where = $request->search;
        if (!empty($where)) {
            $where = array_filter($request->search);
            if (!empty($where)) {
                $i = 0;
                foreach($where as $key => $condition) {
                    $conditions[$i]['column'] = $key;
                    $conditions[$i]['operator'] = '=';
                    $conditions[$i]['value'] = $condition;
                    $i++;
                }
            }
        }
        return $this->order->get($conditions, !empty($request->sortBy) ? $request->sortBy : 'id', !empty($request->sortType) ? $request->sortType : 'asc', $request->page, $request->rowsPerPage);   
    }
    public function create(Store $request): void
    {
        $insertableData = [
            'customer_id' => $request->customer_id,
        ];
        $this->order->create($insertableData);
    }
    public function find(int $id): mixed
    {
        return $this->order->find($id);
    }
    public function delete(int $id): void
    {
        $this->order->delete($id);
    }
    public function attachProduct(int $id, AttachProduct $request): array
    {
        $order = $this->order->find($id);
        if ($order->payed) {
            return ['status' => 422, 'message' => trans('order.error.unable_to_attach_product')];
        }
        if ($this->orderProduct->exists(
                [
                    [
                        'column' => 'order_id',
                        'operator' => '=',
                        'value' => $id,
                    ],
                    [
                        'column' => 'product_id',
                        'operator' => '=',
                        'value' => $request->product_id,
                    ]
                ]
            )
        ) {
            return ['status' => 422, 'message' => trans('order.error.product_already_attached')];
        }
        $this->orderProduct->create([
            'order_id' => $id,
            'product_id' => $request->product_id
        ]);

        return ['status' => 200, 'message' => trans('order.success.product_attached')];
    }
    public function DeAttachProduct(int $id, DeAttachProduct $request): array
    {
        $order = $this->order->find($id);
        if ($order->payed) {
            return ['status' => Response::HTTP_UNPROCESSABLE_ENTITY, 'message' => trans('order.error.unable_to_deattach_product')];
        }
        if (!$this->orderProduct->exists(
                [
                    [
                        'column' => 'order_id',
                        'operator' => '=',
                        'value' => $id,
                    ],
                    [
                        'column' => 'product_id',
                        'operator' => '=',
                        'value' => $request->product_id,
                    ]
                ]
            )
        ) {
            return ['status' => Response::HTTP_UNPROCESSABLE_ENTITY, 'message' => trans('order.error.product_not_attached')];
        }
        $orderProduct = $this->orderProduct->findWhere([
            [
                'column' => 'order_id',
                'operator' => '=',
                'value' => $id,
            ],
            [
                'column' => 'product_id',
                'operator' => '=',
                'value' => $request->product_id,
            ]
        ]);
        $this->orderProduct->delete($orderProduct->id);
        return ['status' => Response::HTTP_OK, 'message' => trans('order.success.product_deattached')];
    }
    public function pay(int $id): array
    {
        $order = $this->order->find($id);
        if ($order->payed) {
            return ['status' => Response::HTTP_UNPROCESSABLE_ENTITY, 'message' => trans('order.error.already_payed')];
        }
        $this->order->update($id, ['payed' => true]);

        return ['status' => Response::HTTP_OK, 'message' => trans('order.success.payed')];
    }
}