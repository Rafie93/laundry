<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductVariant;
use App\Http\Resources\Products\VariantList as ListResource;

class VariantController extends Controller
{
    public function index(Request $request,$productId)
    {
        $variants = ProductVariant::where('product_id',$productId)->get();
        return new ListResource($variants);
    }
}
