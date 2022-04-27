<?php

namespace App\Http\Resources\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageItem extends JsonResource
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
            'package' => $this->resource->package,
            "price" => intval($this->resource->price),
            "duration" => intval($this->resource->duration),
            "duration_day" => $this->resource->duration_day,
            "maks_transaksi" => intval($this->resource->maks_transaksi),
            "cashier" => intval($this->resource->cashier),
            "branch" => intval($this->resource->branch),
            "footer" => $this->resource->footer,
            "qris" => $this->resource->qris,
            "report_to_wa" => $this->resource->report_to_wa,
            "auto_send_nota" => $this->resource->auto_send_nota,
        ];   
     }
}
