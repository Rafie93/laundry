<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class ParfumeItem extends JsonResource
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
            'id'      => intval($this->resource->id),
            'outlet_id' => intval($this->resource->outlet_id),
            'name' => $this->resource->name,
            'price' => intval($this->resource->price)
        ]; 
    }
}
