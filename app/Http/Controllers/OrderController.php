<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\AttachProduct;
use App\Http\Requests\Orders\DeAttachProduct;
use App\Http\Requests\Orders\Index;
use App\Http\Requests\Orders\Store;
use App\Http\Resources\Orders\Index as ListOrdersResource;
use App\Http\Resources\Orders\Store as StoreOrdersResource;
use App\Http\Resources\Orders\Detail as DetailOrdersResource;
use App\Http\Resources\Orders\Delete as DeleteOrdersResource;
use App\Http\Resources\Orders\AttachProduct as AttachProductOrderResource;
use App\Http\Resources\Orders\DeAttachProduct as DeAttachProductOrderResource;
use App\Http\Resources\Orders\Pay as PayOrderResource;
use App\Interfaces\Services\Order as OrderServiceInterfce;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    private OrderServiceInterfce $orderService;

    public function __construct(OrderServiceInterfce $orderServie)
    {
        $this->orderService = $orderServie;
    }

    /**
     * Display a listing of the resource with pagination.
     * 
     * @param  \App\Http\Requests\Orders\Index $request
     * @return \App\Http\Resources\Orders\Index
     */
    public function index(Index $request)
    {
        $records = $this->orderService->get($request);

        return new ListOrdersResource($records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Orders\Store  $request
     * @return \App\Http\Resources\Orders\Store
     */
    public function store(Store $request)
    {
        $this->orderService->create($request);

        return new StoreOrdersResource([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\Orders\Detail
     */
    public function show($id)
    {
        $order = $this->orderService->find($id);
        if (empty($order)) {
            return response()->json([
                'error' => trans('order.error.not_found'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new DetailOrdersResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Http\Resources\Orders\Delete
     */
    public function destroy($id)
    {
        $order = $this->orderService->find($id);
        if (empty((array) $order)) {
            return response()->json([
                'error' => trans('order.error.not_found'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $this->orderService->delete($id);

        return new DeleteOrdersResource([]);
    }

    /**
     * Attach product to an order
     *
     * @param  int  $id
     * @param  \App\Http\Requests\Orders\AttachProduct  $request
     * @return \App\Http\Resources\Orders\AttachProductOrderResource
     */
    public function attachProduct($id, AttachProduct $request)
    {
        $order = $this->orderService->find($id);
        if (empty((array) $order)) {
            return new DeAttachProductOrderResource([
                'message' => trans('order.error.not_found'),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
        }
        $response = $this->orderService->attachProduct($id, $request);

        return new AttachProductOrderResource($response);
    }

    /**
     * Attach product to an order
     *
     * @param  int  $id
     * @param  \App\Http\Requests\Orders\DeAttachProduct  $request
     * @return \App\Http\Resources\Orders\DeAttachProductOrderResource
     */
    public function deAttachProduct($id, DeAttachProduct $request)
    {
        $order = $this->orderService->find($id);
        if (empty((array) $order)) {
            return new DeAttachProductOrderResource([
                'message' => trans('order.error.not_found'),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
        }
        $response = $this->orderService->DeAttachProduct($id, $request);

        return new DeAttachProductOrderResource($response);
    }
    /**
     * Attach product to an order
     *
     * @param  int  $id
     * @return \App\Http\Resources\Orders\PayOrderResource
     */
    public function pay($id)
    {
        $order = $this->orderService->find($id);
        if (empty((array) $order)) {
            return new PayOrderResource([
                'message' => trans('order.error.not_found'),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
        }
        $response = $this->orderService->pay($id);
        return new PayOrderResource($response);
    }
}