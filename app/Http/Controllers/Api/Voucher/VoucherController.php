<?php

namespace App\Http\Controllers\Api\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlets\Promo;
use App\Http\Resources\Voucher\VoucherList as ListResource;
use Carbon\Carbon;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index(Request $request)
    {

        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Promo::orderBy('date_end','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

        return new ListResource($data);
    }

    public function berlaku(Request $request)
    {

        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Promo::orderBy('date_end','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->whereDate('date_start','<=',Carbon::now())
                        ->whereDate('date_end','>=',Carbon::now())
                        ->get();

        return new ListResource($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();                            
           $request->merge(['outlet_id'=>$user->outlet_id]);
        }
        Promo::create($request->all());
        return response()->json(['success'=>true,'message'=>'Promo Berhasil ditambahkan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $items = Promo::find($id);
        $items->update($request->all());
        return response()->json(['success'=>true,'message'=>'Promo Berhasil diperbaharui'], 200);
    }
    
    public function delete(Request $request,$id)
    {
        $items = Promo::find($id);
        $items->delete();
        return response()->json(['success'=>true,'message'=>'Promo Berhasil dihapus'], 200);

    }
}
