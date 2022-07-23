<?php

namespace App\Http\Resources\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Subscription\PackageItem as ItemResource;

class SubscribeItem extends JsonResource
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
            'number' => $this->resource->number,
            "merchant_id" => intval($this->resource->merchant_id),
            "package_number_id" => intval($this->resource->package_member_id),
            'package_name' => $this->resource->package->package,
            'packages' => new ItemResource($this->resource->package),
            "amount" => intval($this->resource->amount),
            "status" => intval($this->resource->status),
            "date" => $this->resource->date,
            "payment_link" => $this->resource->payment_link,
            "payment_status" => $this->resource->payment_status == null ? 'waiting payment' : $this->resource->payment_status,
            "payment_token" => $this->resource->payment_token,
            "customer_name" => $this->resource->customer_name,
            "customer_phone" => $this->resource->customer_phone,
            "customer_email" => $this->resource->customer_email,
        ];  
    }
}
