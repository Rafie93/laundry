<?php

namespace App\Http\Resources\Information;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Information\NewsItem as ItemResource;

class NewsList extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) use ($request) {
            return (new ItemResource($item))->toArray($request);
        });
    }
}
