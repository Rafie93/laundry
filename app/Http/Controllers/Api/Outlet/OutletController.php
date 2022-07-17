<?php

namespace App\Http\Controllers\Api\Outlet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Outlets\Outlet;
use App\Models\Outlets\Merchant;
use App\Http\Resources\Outlet\OutletList as ListResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistem\PackageMember;

class OutletController extends Controller
{
    public function index()
    {
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                ->where('status',1)
                                ->first();
                                
        $stores = Outlet::orderBy('merchant_id','asc')
                        ->where(function ($query) use ($owner) {
                            if (auth()->user()->role==2 ){
                                $query->where('merchant_id',$owner->id);
                            }else{
                                $query->where('id',$user->outlet_id);
                            }
                        })
                        ->get();

        return new ListResource($stores);
    }


    public function store(Request $request)
    {
        if (auth()->user()->role!=2 ){
            return response()->json(['success'=>false,'message'=>'Anda Bukan Owner'], 400);
        }
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();
        if ($owner) {
           $packageId = $owner->package_member_id;
           $paket  = PackageMember::where('id',$packageId)->first();
           $branch = $paket->branch == null ? 9999999999 : $paket->branch;
           $count = Outlet::where('merchant_id',$owner->id)->count();
           if ($count>=$branch) {
                return response()->json(['success'=>false,'message'=>'Maksimal Outlet Anda Sebanyak '.$branch], 400);
           }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'address'    => 'required',
            'phone'=>'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }

        $store = Outlet::create([
            'merchant_id' => $owner->id, 
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'code' => $request->code,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'logo' => $request->logo,
            'latitude' => $request->latitude ? $request->latitude:0,
            'longitude' => $request->longitude ? $request->longitude:0,
            'status' => 1
        ]);
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/stores/',$fileName);
            $store->logo= $fileName;
            $store->save();
       }
       return response()->json(['success'=>true,'message'=>'Data Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        if (auth()->user()->role!=2 ){
            return response()->json(['success'=>false,'message'=>'Anda Bukan Owner'], 400);
        }
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'address'    => 'required',
            'phone'=>'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }

        $store = Outlet::find($id)->update([
            'merchant_id' => $owner->id, 
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'code' => $request->code,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'logo' => $request->logo,
            'latitude' => $request->latitude ? $request->latitude:0,
            'longitude' => $request->longitude ? $request->longitude:0,
            'status' => 1
        ]);
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/stores/',$fileName);
            $store->logo= $fileName;
            $store->save();
       }
       return response()->json(['success'=>true,'message'=>'Data Berhasil diperbaharui'], 200);
    }
}
