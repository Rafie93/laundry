<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores\Tax;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        $taxs = Tax::where('store_id',auth()->user()->store_id)->get();
        return view('tax.index',compact('taxs'));
    }
    public function store(Request $request)
    {
        foreach ($request->code as $i => $code) {
            if ($code=="PPN") {
                $status=$request->status_ppn[0];
            }else{
                $status=$request->status_charge[0];
            }
            Tax::updateOrInsert([
                'store_id' =>  auth()->user()->store_id,
                'code' => $code
            ],
            [
                'store_id'=> auth()->user()->store_id,
                'code' => $code,
                'name' => $request->name[$i],
                'type' => $request->type[$i],
                'amount' => $request->amount[$i],
                'status' => $status
            ]);
        }
        return redirect()->route('tax')->with('message','Tax diperbaharui');
    }
}
