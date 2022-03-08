<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class SeatItem extends JsonResource
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
            'store_name' => $this->resource->store->name,
            'table_number' => $this->resource->table_number,
            'description' => $this->resource->description,
            'sequence' => $this->resource->sequence,
            'minimum_shopping' => $this->resource->minimum_shopping,
            'maximum' => $this->resource->maximum,
            'is_ready' => $this->resource->is_ready,
            'image'  => $this->resource->image()
        ];
    }
}
