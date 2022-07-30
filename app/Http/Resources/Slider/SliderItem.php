<?php

namespace App\Http\Resources\Slider;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderItem extends JsonResource
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
            'title'      => $this->resource->title,
            'description'     => $this->resource->description,
            'link'     => $this->resource->link,
            'slide'  => $this->resource->file(),
        ];
    }
}
