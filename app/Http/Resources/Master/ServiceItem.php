<?php

namespace App\Http\Resources\Master;


use Illuminate\Http\Resources\Json\JsonResource;

class ServiceItem extends JsonResource
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
            'category_id' => intval($this->resource->category_id),
            'category_name' => $this->resource->category->name,
            'name' => $this->resource->name,
            'price' => intval($this->resource->price),
            'satuan' => $this->resource->satuan,
            'estimasi' => $this->resource->estimasi,
            'estimasi_type' => $this->resource->estimasi_type,
            'icon' => $this->resource->icon,
        ]; 
    }
}
