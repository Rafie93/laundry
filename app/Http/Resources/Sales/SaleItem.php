<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Sales\SaleDetail;

class SaleItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $det = array();
        $item_string = "";
        foreach ($this->resource->detail as $row) {
            $det[] = array(
                'sale_id' => $row->sale_id,
                'product_id' => $row->product_id,
                'product_name' => $row->products->name,
                'qty' => $row->qty,
                'price' => $row->price,
                'price_promo' => $row->price_promo,
                'price_variant' => $row->price_variant,
                'subtotal' => $row->subtotal,
                'notes'=> $row->notes
            );
            $item_string .= $row->qty."x ".$row->products->name."\n";
        }
        if ($this->resource->type_sales==3) {
            foreach ($this->resource->events as $row) {
                $det[] = array(
                    'sale_id' => $row->sale_id,
                    'product_id' => strval($row->event->id),
                    'product_name' => $row->event->name,
                    'qty' => strval($row->qty),
                    'price' => strval($row->event->price),
                    'price_promo' => "0",
                    'price_variant' => "0",
                    'subtotal' => strval($row->event->price * $row->qty),
                    'notes'=> ""
                );
                $item_string .= $row->qty."x ".$row->event->name."\n";
            }
        }
        return  [
            'id'      => $this->resource->id,
            'firebase_id'      => $this->resource->firebase_id,
            'type_sales' => $this->resource->type_sales,
            'store_id'     => $this->resource->store_id,
            'store_name'     => $this->resource->stores->name,
            'number'     => $this->resource->number,
            'date' =>  $this->resource->date,
            'member_id'      => $this->resource->member_id,
            'sub_total'      => $this->resource->sub_total,
            'variant_total' => $this->resource->variant_total,
            'shipping_total'     => $this->resource->shipping_total,
            'tax_total'     => $this->resource->tax_total,
            'fee_total' =>  $this->resource->fee_total,
            'discount_total'      => $this->resource->discount_total,
            'admin_total'      => $this->resource->admin_total,
            'point_total' => $this->resource->point_total,
            'grand_total'     => $this->resource->grand_total,
            'modal_total'     => $this->resource->modal_total,
            'payment_method' =>  $this->resource->payment_method,
            'payment_status'      => $this->resource->payment_status,
            'payment_no' =>  $this->resource->payment_no,
            'payment_expired'      => $this->resource->payment_expired,
            'service'      => $this->resource->service,
            'shipping_method' => $this->resource->shipping_method,
            'origin_id'     => $this->resource->origin_id,
            'customer_name'     => $this->resource->customer_name,
            'customer_phone' =>  $this->resource->customer_phone,
            'destination_city' => $this->resource->destination_city,
            'destination' =>  $this->resource->destination->name,
            'address'     => $this->resource->address,
            'postal_code'     => $this->resource->postal_code,
            'pickup_date' =>  $this->resource->pickup_date,
            'customer_phone' =>  $this->resource->customer_phone,
            'seat_reservation_date' => $this->resource->seat_reservation_date,
            'seat_reservation_start'     => $this->resource->seat_reservation_start,
            'seat_reservation_end'     => $this->resource->seat_reservation_end,
            'seat' =>  $this->resource->seat,
            'status' => $this->resource->status,
            'notes' => $this->resource->notes,
            'created_at' => $this->resource->created_at->format('D, d M Y'),
            'total_item' => $this->resource->detail->count(),
            'item_string'=>$item_string,
            'detail' => $det
        ];
    }
}
