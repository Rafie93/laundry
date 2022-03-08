<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id'      => $this->resource->id,
            'sale_id'      => $this->resource->sale_id,
            'product_id' => $this->resource->product_id,
            'price'     => $this->resource->price,
            'price_promo'     => $this->resource->price_promo,
            'price_variant' =>  $this->resource->price_variant,
            'qty' =>  $this->resource->qty,
            'subtotal' =>  $this->resource->subtotal,
            'notes' =>  $this->resource->notes,
            'rating' =>  $this->resource->rating,
            'ulasan' =>  $this->resource->ulasan,
        ];
    }
}
