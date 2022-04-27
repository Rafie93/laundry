<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Users\UserManajemen;
use App\Models\Outlets\Outlet;
use App\Models\Outlets\Merchant;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'phone'   => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'outletname' => 'required',
            'outletphone' => 'required',
            'outletemail' => 'required',
            'outletaddress' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
     
        $request->merge([
            'status' => 1,
            'role' => 2,
            'password' => bcrypt($request->password)
        ]);

        $users = User::create($request->all());
        $userId = $users->id;

        $merchants = Merchant::create([
            'name' => $request->fullname,
            'phone' => $request->phone,
            'owner_id' => $userId,
            'package_member_id' => 1,
            'status' => 1,
            'expired' => \Carbon\Carbon::now()->addDays(15),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $outlets = Outlet::create([
            'merchant_id' => $merchants->id,
            'code' => $request->code,
            'name' => $request->outletname,
            'phone' => $request->outletphone,
            'email' => $request->outletemail,
            'address' => $request->outletaddress,
            'city_id' => $request->cityid,
            'district_id' => $request->districtid,
            'latitude' => $request->latitude,
            'longitude'=> $request->longitude,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        UserManajemen::create([
            'user_id' => $userId,
            'role' => 2,
            'status' => 1,
            'outlet_id' => $outlets->id,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        return response()->json(['success'=>true,'message'=>'Silahkan Login Kembali'], 200);
    }
    

}
