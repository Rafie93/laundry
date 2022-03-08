<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Products\ProductMerchantItem as ListResource;

class ProductMerchantController extends Controller
{
    public function index(Request $request)
    {
        $products =
              Product::where('type','2')
                 ->where('product_type',1)
                 ->where('status',1)
                 ->where('is_ready',1)
                 ->select('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery')
                 ->groupBy('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery')
                 ->paginate(20);
         
        $productStores =
              Product::where('type','1')
                 ->where('product_type',1)
                 ->where('status',1)
                 ->where('is_ready',1)
                 ->select('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery','store_id','cover')
                 ->groupBy('name','code','category_id','description','price_sales','point_cashback','weight','long_delivery','store_id','cover')
                 ->paginate(20);

        $output = [];
        foreach ($products as $key => $row) {
            $available = [];
            $available_display = "";
            foreach ($row->productAvailableStore($row->code) as $key => $store) {
                $variant = [];
                foreach ($store->variants as $vari){
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
               $available[] = array(
                'id'      => $store->id,
                'name' => $store->name,
                'store_id' => $store->store_id,
                'store_name' => $store->stores->name,
                'product_type' => $store->product_type,
                'code' => $store->code,
                'description' => $store->description,
                'category_id' => $store->category_id,
                'category_name' => $store->category->name,
                'cost_of_goods' => $store->cost_of_goods,
                'price_sales' => $store->price_sales,
                'is_ready' => $store->is_ready,
                'is_ppn' => $store->is_ppn,
                'type' => $store->type,
                'point_cashback' => $store->point_cashback,
                'time_duration' => $store->time_duration,
                'is_stock' => $store->is_stock,
                'long_delivery' => $store->long_delivery,
                'weight' => $store->weight,
                'cover' => $store->cover(),
                'images' => $store->images,
                'sales' => $store->sales->count(),
                'rating'  => $store->sales->count(),
                'variant' => $variant
                    
               );
               $available_display .= $store->store_name.' ';
            }
            $output[] = array(
                'type' => 'merchant',
                'name' => $row->name,
                'code' => $row->code,
                'description' => $row->description,
                'category_id' => $row->category_id,
                'price_sales' => $row->price_sales,
                'point_cashback' => $row->point_cashback,
                'time_duration' => $row->time_duration,
                'long_delivery' => $row->long_delivery,
                'weight' => $row->weight,
                'cover' => $row->coverProductMerchant($row->code),
                'available_display' => $available_display,
                'available' => $available,
               
            );
        }

        foreach ($productStores as $key => $row) {
            $available = [];
            foreach ($row->productFromStore($row->code,$row->name) as $key => $store) {
                $variant = [];
                foreach ($store->variants as $vari){
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
                $available[] = array(
                    'id'      => $store->id,
                    'name' => $store->name,
                    'store_id' => $store->store_id,
                    'store_name' => $store->stores->name,
                    'product_type' => $store->product_type,
                    'code' => $store->code,
                    'description' => $store->description,
                    'category_id' => $store->category_id,
                    'category_name' => $store->category->name,
                    'cost_of_goods' => $store->cost_of_goods,
                    'price_sales' => $store->price_sales,
                    'is_ready' => $store->is_ready,
                    'is_ppn' => $store->is_ppn,
                    'type' => $store->type,
                    'point_cashback' => $store->point_cashback,
                    'time_duration' => $store->time_duration,
                    'is_stock' => $store->is_stock,
                    'long_delivery' => $store->long_delivery,
                    'weight' => $store->weight,
                    'cover' => $store->cover(),
                    'images' => $store->images,
                    'sales' => $store->sales->count(),
                    'rating'  => $store->sales->count() ,
                    'variant' => $variant    
                   );
            }
            
            $available_display = $row->stores->name;
            $output[] = array(
                'type' => 'store',
                'name' => $row->name,
                'code' => $row->code,
                'description' => $row->description,
                'category_id' => $row->category_id,
                'price_sales' => $row->price_sales,
                'point_cashback' => $row->point_cashback,
                'time_duration' => $row->time_duration,
                'long_delivery' => $row->long_delivery,
                'weight' => $row->weight,
                'cover' => $row->cover(),
                'available_display' => $available_display,
                'available' => $available,
               
            );
        }
        return response()->json(['success'=>true,'data'=>$output]);
    }
}
