<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Resources\Json\JsonResource;

class Delete extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => trans('order.success.deleted'),
            'data' => []
        ];
    }
}
