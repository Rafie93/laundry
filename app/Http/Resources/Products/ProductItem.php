<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Products\VariantItem as ItemVariant;
use App\Models\Products\ProductPromo;
class ProductItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $variant = array();
       foreach ($this->resource->variants as $vari){
           $variant[] = array(
                'id'      => $vari->id,
                'product_id' => $vari->product_id,
                'product_name' => $vari->product->name,
                'name'      => $vari->name,
                'type'      => $vari->type,
                'type_display'      => $vari->is_type(),
                'options' => json_decode($vari->options)
           );
       }
       $product_pairing = [];
       foreach ($this->resource->pairings as $pair){
           $product_pairing = json_decode($pair->product_pairing);
       }
       $price_promo = 0;
       $productPromo = ProductPromo::where('product_id',$this->resource->id)
                                    ->where('start_date','<=',date('Y-m-d'))
                                    ->where('end_date','>=',date('Y-m-d'))
                                    ->get();
      if ($productPromo->count()>0) {
         $productPromo = $productPromo->first();
         $type = $productPromo->type;
         if ($type=='percentage') {
            $price_sale = $this->resource->price_sales;
            $price_promo = intval(($price_sale * $productPromo->amount)/100);
         }else{
            $price_promo = intval($productPromo->amount);
         }
         $price_promo = $this->resource->price_sales - $price_promo;
      }
       return  [
            'id'      => $this->resource->id,
            'name' => $this->resource->name,
            'store_id' => $this->resource->store_id,
            'store_name' => $this->resource->stores->name,
            'product_type' => $this->resource->product_type,
            'code' => $this->resource->code,
            'description' => $this->resource->description,
            'category_id' => $this->resource->category_id,
            'category_name' => $this->resource->category->name,
            'cost_of_goods' => $this->resource->cost_of_goods,
            'price_sales' => $this->resource->price_sales,
            'price_promo' => $price_promo,
            'is_ready' => $this->resource->is_ready,
            'is_ppn' => $this->resource->is_ppn,
            'type' => $this->resource->type,
            'point_cashback' => $this->resource->point_cashback,
            'time_duration' => $this->resource->time_duration,
            'is_stock' => $this->resource->is_stock,
            'long_delivery' => $this->resource->long_delivery,
            'weight' => $this->resource->weight,
            'cover' => $this->resource->cover(),
            'images' => $this->resource->images,
            'sales' => $this->resource->sales->count(),
            'rating'  => $this->resource->sales->count(),
            'variant' => $variant,
            'pairing' => $product_pairing
        ];
    }
}
