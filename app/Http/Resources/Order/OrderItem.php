<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $detail =  $this->resource->order_detail;
        $output = array();
        foreach ($detail as $key => $val) {
            $output[] = array(
                'id' => $val->id,
                'service_id' => $val->service_id,
                'service_name' => $val->service->name,
                'service_category' => $val->service->category->name,
                'qty' => $val->qty,
                'price' => $val->price,
                'sub_total' => $val->sub_total,
            );
        }

        return  [
            'id'      => intval($this->resource->id),
            'outlet_id' => intval($this->resource->outlet_id),
            'number' => $this->resource->number,
            'customer_id' => intval($this->resource->customer_id),
            'customer_name' => $this->resource->customer->name,
            'customer_phone' => $this->resource->customer->phone,
            'date_entry' => $this->resource->date_entry,
            'date_complete' => $this->resource->date_complete,
            'date_taken' => $this->resource->date_taken,
            'date_pay' => $this->resource->date_pay,
            'subtotal' => intval($this->resource->subtotal),
            'discount' => intval($this->resource->discount),
            'additional_cost' => intval($this->resource->additional_cost),
            'is_discount' => intval($this->resource->is_discount),
            'nominal_discount' => intval($this->resource->nominal_discount),
            'discount_type' => intval($this->resource->discount_type),
            'grand_total' => intval($this->resource->grand_total),
            'estimated_time' => intval($this->resource->estimated_time),
            'estimated_type' => $this->resource->estimated_type,
            'parfume' => $this->resource->parfume,
            'rak' => $this->resource->rak,
            'voucher_user' => $this->resource->voucher_user,
            'notes' => $this->resource->notes,
            'is_down_payment' => intval($this->resource->is_down_payment),
            'nominal_down_payment' => intval($this->resource->nominal_down_payment),
            'remainder' => intval($this->resource->remainder),
            'metode_payment' => $this->resource->metode_payment,
            'status_payment' => intval($this->resource->status_payment),
            'status_payment_display' => $this->resource->isStatusPayment(),
            'status_order' => intval($this->resource->status_order),
            'status_order_display' => $this->resource->isStatusOrder(),
            'items' => $this->resource->items,
            'pembuat' => $this->resource->creator->fullname,
            'service' => $output,

        ]; 
    }
}
