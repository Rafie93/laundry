<?php

namespace App\Http\Resources\Expenditure;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenditureItem extends JsonResource
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
            'expenditure_category_id' => $this->resource->expenditure_category_id,
            "expenditure_category_name" => $this->resource->category->name,
            "name" => $this->resource->name,
            "date" => $this->resource->date,
            "cost" => intval($this->resource->cost),
            "note" => $this->resource->note,
            "status" => $this->resource->status,
            "creator_id" => intval($this->resource->creator_id)
        ];  
    }
}
