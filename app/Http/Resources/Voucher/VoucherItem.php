<?php

namespace App\Http\Resources\Voucher;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherItem extends JsonResource
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
            "name" => $this->resource->name,
            "amount" => $this->resource->amount,
            "type" => $this->resource->type,
            "date_start" => $this->resource->date_start,
            "date_end" => $this->resource->date_end,
            "description" => $this->resource->description
        ];
    }
}
