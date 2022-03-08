<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\JsonResource;

class MethodItem extends JsonResource
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
            'code'      => $this->resource->code,
            'name' => $this->resource->name,
            'type'     => $this->resource->type,
            'fee'     => floatval($this->resource->fee),
            'charged' =>  $this->resource->charged,
        ];
    }
}
