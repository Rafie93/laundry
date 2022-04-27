<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class SatuanItem extends JsonResource
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
            'outlet_name' => $this->resource->outlet->name,
            'name' => $this->resource->name,
            'alias' => $this->resource->alias
        ]; 
    }
}
