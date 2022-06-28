<?php

namespace App\Http\Controllers\Shopp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlets\Promo;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
         $vouchers = StoreVoucher::orderBy('id','desc')
                        ->paginate(20);
        if (auth()->user()->IN_STORE()) {
            $vouchers = StoreVoucher::orderBy('id','desc')
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('voucher.index',compact('vouchers'));
    }

    public function create(Request $request)
    {
       return view('voucher.create');
    }
    public function edit(Request $request,$id)
    {
        $data = StoreVoucher::find($id);
       return view('voucher.edit',compact('data'));
    }
    public function store(Request $request)
    {
         $this->validate($request,[
            'start_date' => 'required|date',
            'expired_at' => 'required|date',
            'amount'=> 'required|numeric',
            'code'=>'required|unique:store_voucher',
            'name'=>'required',
            'amount_type'=>'required'
        ]);
         if(auth()->user()->role!=11){
            $request->merge(['store_id'=>auth()->user()->store_id]);
        }
      
        DB::beginTransaction();
         StoreVoucher::create($request->all());
        DB::commit();
        return redirect()->route('voucher')->with('message','Voucher Berhasil dibuat');
    }
      public function update(Request $request)
    {
         $this->validate($request,[
            'start_date' => 'required|date',
            'expired_at' => 'required|date',
            'amount'=> 'required|numeric',
            'code'=>'required|unique:store_voucher',
            'name'=>'required',
            'amount_type'=>'required'
        ]);
      
        DB::beginTransaction();
            $voucher = StoreVoucher::find($id);
            $voucher->update($request->all());
        DB::commit();
        return redirect()->route('voucher')->with('message','Voucher Berhasil diperbaharui');
    }

    public function delete($id)
    {
        $seat=StoreVoucher::find($id);
        $seat->delete();
        return redirect()->route('voucher')->with('message','Berhasil dihapus');
    }
}
