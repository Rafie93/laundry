<?php

namespace App\Http\Resources\Master;


use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Master\ServiceItem as ItemResource;

class ServiceList extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) use ($request) {
            return (new ItemResource($item))->toArray($request);
        });  
    }
}
