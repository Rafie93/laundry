<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sistem\SettingCourier;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $couriers = SettingCourier::where('status',1)->get();
        return response()->json(['success'=>true,'data'=> $couriers], 200);
    }
}
