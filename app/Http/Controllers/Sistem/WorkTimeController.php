<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\StoreWork;
class WorkTimeController extends Controller
{
    public function index(Request $request)
    {
        $works = StoreWork::where('store_id',auth()->user()->store_id)->get();
        return view('worktime.index',compact('works'));
    }
    public function store(Request $request)
    {
        foreach ($request->day as $i => $day) {
            StoreWork::updateOrInsert([
                'store_id' =>  auth()->user()->store_id,
                'day' => $day
            ],
            [
                'store_id'=> auth()->user()->store_id,
                'day' => $day,
                'open_time' => $request->open_time[$i],
                'close_time' => $request->close_time[$i],
            ]);
        }
        return redirect()->route('worktime')->with('message','Jam Kerja diperbaharui');

    }
}
