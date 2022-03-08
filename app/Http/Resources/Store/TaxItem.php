<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {       
          return  [
            'id'      => $this->resource->id,
            'store_id' => $this->resource->store_id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'amount' => $this->resource->amount
        ];
    }
}
