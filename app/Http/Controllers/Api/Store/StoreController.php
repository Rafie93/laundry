<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\Store;
use App\Http\Resources\Store\StoreList as ListResource;

class StoreController extends Controller
{
     public function index(Request $request)
    {
        $store = Store::orderBy('id','asc')
                            ->where('status',1)
                            ->get();

        return new ListResource($store);
    }
}
