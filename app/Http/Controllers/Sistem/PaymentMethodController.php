<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sistem\PaymentMethod;

class PaymentMethodController extends Controller
{
     public function index(Request $request)
    {
        $payments = PaymentMethod::all();
        return view('payment.index',compact('payments'));
    }
    public function store(Request $request)
    {
         foreach ($request->code as $i => $code) {
            PaymentMethod::updateOrInsert([
                'code' => $code
            ],
            [
                'code' => $code,
                'name' => $request->name[$i],
                'type' => $request->type[$i],
                'fee' => $request->fee[$i],
                'charged' => $request->charged[$i],
                'status' => $request->status[$i],
            ]);
        }
        return redirect()->route('paymentmethod')->with('message','Payment Method diperbaharui');
    }
}
