<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Products\Product;
class BundleItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bundle = json_decode($this->resource->products->bundle_product);
        $bdl=array();
        foreach ($bundle as $key => $value) {
            $p = Product::where('id',$value->id)->first();
            $image ="";
            if ($p) {
               $image = $p->cover();
            }
            $bdl[] = array(
                'id' => $value->id,
                'name' => $value->name,
                'qty' => $value->qty,
                'image' => $image
            );
        }
        return  [
            'id'      => $this->resource->id,
            'name' => $this->resource->name,
            'store_id' => $this->resource->store_id,
            'store_name' => $this->resource->stores->name,
            'product_id' => $this->resource->product_id,
            'product_name' => $this->resource->products->name,
            'price'  => $this->resource->price,
            'quantity'  => $this->resource->price,
            'description' => $this->resource->description,
            'expired' => $this->resource->expired,
            'day' => $this->resource->day,
            'point_cashback' => $this->resource->products->point_cashback,
            'cover' => $this->resource->products->cover(),
            'bundle' => $bdl

        ];
    }
}
