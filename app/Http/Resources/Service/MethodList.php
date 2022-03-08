<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Service\MethodItem as ItemResource;

class MethodList extends ResourceCollection
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
