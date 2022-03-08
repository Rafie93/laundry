<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\JsonResource;

class EventItem extends JsonResource
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
            "store_id" => $this->resource->store_id,
            "store_name" => $this->resource->stores->name,
            "name" => $this->resource->name,
            "date" => $this->resource->date,
            "date_end" => $this->resource->date_end,
            "term_condition" => $this->resource->term_condition,
            "description" => $this->resource->description,
            "price" => $this->resource->price,
            "point_cashback" => $this->resource->point_cashback,
            "image" => $this->resource->image(),
            "category" => $this->resource->category,
            "online_link" => $this->resource->online_link,
            "subscription" => 0,
            "is_kouta" => $this->resource->kouta == null ? false : true,
            "kouta" => $this->resource->kouta,
            "min_purchased" => $this->resource->min_purchased,
            "max_purchased" => $this->resource->max_purchased,
        ];
    }
}
