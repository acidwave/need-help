<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total = 0;
        foreach ($this->items as $key => $value) {
            $total += $value->cost * $value->quantity;
        }
        return [
            'id' => $this->id,
            'status' => $this->status->title,
            'items' => OrderItemResource::collection($this->items),
            'quantity' => $this->items_count,
            'total' => round($total, 2),
        ];
    }
}
