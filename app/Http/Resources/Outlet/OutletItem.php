<?php

namespace App\Http\Resources\Outlet;

use Illuminate\Http\Resources\Json\JsonResource;

class OutletItem extends JsonResource
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
            'merchant_id' => intval($this->resource->merchant_id),
            'code' => $this->resource->code,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'email' => $this->resource->email,
            'city_id' => strval($this->resource->city_id),
            'district_id' => strval($this->resource->district_id),
            'address' => $this->resource->address,
            'logo' => $this->resource->logo
        ]; 
    }
}
