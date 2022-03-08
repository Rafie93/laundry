<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductBundle;

class ProductBundleController extends Controller
{
    public function index(Request $request)
    {
        $category = ProductBundle::orderBy('name','asc')
                        ->when($request->store_id, function ($query) use ($request) {
                            $query->where('store_id', $request->store_id);
                        });
        if ($request->store_id==null) {
            $category->whereNull('store_id');
        }
        return new ListResource($category->get());
    }
}
