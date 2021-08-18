<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            $value->item->cost = round($value->item->cost * $this->discount, 2);
            $total += $value->item->cost * $value->quantity;
        }
        return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->items),
            'quantity' => $this->items_count,
            'total' => round($total, 2),
        ];
    }
}
