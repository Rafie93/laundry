<?php

namespace App\Http\Resources\Events;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Events\EventItem as ItemResource;

class EventList extends ResourceCollection
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
