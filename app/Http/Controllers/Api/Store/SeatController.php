<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\StoreTable;
use App\Http\Resources\Store\SeatList as ListResource;

class SeatController extends Controller
{
    public function index(Request $request,$id)
    {
        $seats = StoreTable::orderBy('sequence','asc')
                            ->where('store_id',$id)
                            ->where('status',1)
                            ->get();

        return new ListResource($seats);
    }
}
