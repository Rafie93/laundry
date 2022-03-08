<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Store\SeatItem as ItemResource;

class SeatList extends ResourceCollection
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
