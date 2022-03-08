<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sistem\SettingCourier;

class CourierController extends Controller
{
    public function index(Request $request)
    {
       $couriers = SettingCourier::all();
       return view('setting.courier.index',compact('couriers'));
    }
    
    public function store(Request $request)
    {
        foreach ($request->name as $i => $name) {
            SettingCourier::updateOrInsert([
                'name' => $name
            ],
            [
                'name' => $name,
                'distance' => $request->distance[$i],
                'rate' => $request->rate[$i],
                'min_rate' => $request->min_rate[$i],
                'min_distance' => $request->min_distance[$i],
                'status' => $request->status[$i]
            ]);
        }
        return redirect()->route('courier')->with('message','Tarif Biaya Kurir diperbaharui');
    }
}
