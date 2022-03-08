<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductBundle;
use Carbon\Carbon;
use App\Http\Resources\Products\BundleList as ListResource;

class ProductSubscription extends Controller
{
    public function index(Request $request)
    {
        $products = ProductBundle::orderBy('expired','asc')
                        ->where('expired','>',Carbon::now());
        return new ListResource($products->get());
        }
}
