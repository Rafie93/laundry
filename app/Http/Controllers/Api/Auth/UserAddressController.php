<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Users\UserAddress;

class UserAddressController extends Controller
{
    public function index(Request $request)
    {
        $address = UserAddress::orderBy('is_main','desc')
                                ->where('user_id',auth()->user()->id)
                                ->get();
        $data = array();
        foreach ($address as $row) {
            $data[] = array(
                'id' => $row->id,
                'city_id' => $row->city_id,
                'city' => $row->city->name,
                'province_id' => $row->city->province_id,
                'province' => $row->city->province,
                'district_id' => $row->district_id,
                'district_name' => $row->district_name,
                'address' => $row->address,
                'postalcode' => $row->postalcode,
                'latitude' => strval($row->latitude),
                'longitude' => strval($row->longitude),
                'is_main' => $row->is_main
            );
        }

        return response()->json(['success'=>true,'data'=> $data], 200);


    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'city_id' => 'required',
            'address'    => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $user = UserAddress::where('user_id',auth()->user()->id)->where('is_main',1)->get()->count();
        if ($user==0) {
            $is_main = 1;
        }else{
            $is_main = $request->is_main ? $request->is_main : 0;
        }

        $request->merge([
            'user_id' => auth()->user()->id,
            'is_main' => $is_main
        ]);
        $data = UserAddress::create($request->all());
        if ($request->is_main == 1) {
            UserAddress::where('user_id',auth()->user()->id)
                        ->where('id','!=',$data->id)
                        ->update(
                            ['is_main' => 0]
                        );
        }
        return response()->json(['success'=>true,'message'=>'Alamat diperbaharui','data'=> $data], 200);

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'city_id' => 'required',
            'address'    => 'required',
            'is_main' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $data = UserAddress::find($id)->update($request->all());
        if ($request->is_main == 1) {
            UserAddress::where('user_id',auth()->user()->id)
                        ->where('id','!=',$id)
                        ->update(
                            ['is_main' => 0]
                        );
        }
        return response()->json(['success'=>true,'message'=>'Alamat diperbaharui','data'=> $data], 200);
    }
}
