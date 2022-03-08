<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Products\ProductList as ListResource;
use App\Http\Resources\Products\ProductItem;

class ProductController extends Controller
{
    public function index(Request $request,$storeId)
    {
        $products = Product::orderBy('id','desc')
                        ->where('product_type',1)
                        ->where('status',1)
                        ->where('store_id',$storeId)
                        ->paginate(20);

        return new ListResource($products);
    }
     public function detail(Request $request,$id)
    {
        $product = Product::where('id',$id)->first();
        return response()->json([
         'data' =>  new ProductItem($product)
        ],200);
    }
}
