<?php

namespace App\Http\Controllers\Api\Outlet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outlets\Customer;
use App\Http\Resources\Outlet\CustomerList as ListResource;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                            ->where('status',1)
                            ->first();
                            
        $customer = Customer::orderBy('id','desc')
                            ->where('outlet_id',$user->outlet_id)
                            ->get();

        return new ListResource($customer);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required'
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
        Customer::create($request->all());
        return response()->json(['success'=>true,'message'=>'Customer Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $items = Customer::find($id);
        $items->update($request->all());
        return response()->json(['success'=>true,'message'=>'Customer Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request)
    {
        $items = Customer::find($id);
        $items->delete();
        return response()->json(['success'=>true,'message'=>'Customer Berhasil dihapus'], 200);
    }
}
