<?php

namespace App\Http\Resources\Information;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsItem extends JsonResource
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
            'tag' => $this->resource->tag,
            'description'     => $this->resource->description,
            'cover'  => $this->resource->cover(),
        ];
    }
}
