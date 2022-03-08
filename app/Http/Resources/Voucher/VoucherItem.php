<?php

namespace App\Http\Resources\Voucher;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Stores\Store;

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
        $storeName = "";
        if ($this->resource->store_id != null) {
            $storeName = Store::find($this->resource->store_id)->name;
        }
          return  [
            'id'      => $this->resource->id,
            'store_id' => $this->resource->store_id,
            'store_name' => $storeName,
            "code" => $this->resource->code,
            "name" => $this->resource->name,
            "amount" => $this->resource->amount,
            "amount_type" => $this->resource->amount_type,
            "is_higher_amount" => $this->resource->is_higher_amount,
            "higher_amount" => $this->resource->higher_amount,
            "maximum_amount" => $this->resource->maximum_amount,
            "maximum_user" => $this->resource->maximum_user,
            "expired_at" => $this->resource->expired_at,
            "status" => $this->resource->status,
            "minimum_shopp" => $this->resource->minimum_shopp
        ];
    }
}
