<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\Tax;
use App\Http\Resources\Store\TaxList as ListResource;

class TaxController extends Controller
{
    public function index(Request $request,$id)
    {
        $taxs = Tax::orderBy('id','asc')
                            ->where('store_id',$id)
                            ->where('status',1)
                            ->get();

        return new ListResource($taxs);
    }
}
