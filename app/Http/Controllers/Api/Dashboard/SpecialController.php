<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductSpecial;
class SpecialController extends Controller
{
    public function index(Request $request)
    {
        $output = array();
        if ($request->keyword!="") {
            $products = ProductSpecial::where('keyword_city','like','%'.$request->keyword.'%')->get();
            foreach ($products as $s) {
                $output[] = array(
                    'product_id' => $s->product_id,
                    'product_name' => $s->product->name,
                    'store_id' => $s->store_id,
                    'store_name'=> $s->store->name,
                    'price' => $s->product->price_sales,
                    'description' => $s->product->description
                );
            }
        }
        return response()->json(['success'=>true,'data'=> $output], 200);

    }
}
