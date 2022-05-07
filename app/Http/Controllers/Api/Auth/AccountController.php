<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
Use App\Models\Outlets\Outlet;
Use App\Models\Users\UserManajemen;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return new UserResource($user);
    }
    public function myOutlet()
    {
        $userManajemen = UserManajemen::where('user_id',auth()->user()->id)
                                ->where('status',1)
                                ->first();
        $outlet = Outlet::where('id',$userManajemen->outlet_id)->first();

        $awal  = date_create($outlet->merchant->expired);
        $akhir = date_create(); 
        $diff  = date_diff( $awal, $akhir );
        if ($akhir > $awal) {
            $hari = "0 Hari";
            $status = "Expired";
        }else{
            $hari = $diff->days." Hari";
            $status = "Aktif";
        }
        $data = array(
            'role' => intval($userManajemen->role),
            'outlet_id' => intval($userManajemen->outlet_id),
            'outlet_name' => $outlet->name,
            'hari' => $hari,
            'status' => $status,
            'owner_id'=> int($outlet->merchant->id),
            'owner' => $outlet->merchant->name,
            'owner_phone' => $outlet->merchant->phone,
            'paket' => $outlet->merchant->package->package,
            'duration'=> int($outlet->merchant->package->duration),
            'duration_day' => $outlet->merchant->package->duration_day,
        );
        return response()->json($data);
    }
   
    public function changeProfile(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'fullname' => 'required|min:2',
            'email'    => 'required|unique:users.'.$user->id,
            'phone'=>'required|unique:users.'.$user->id,
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $user->update([
            "fullname" => $request->fullname,
            'email'=> $request->email,
            'birthday'=>$request->birthday,
            'gender' => $request->gender
        ]);
        return response()->json(['success'=>true,'message'=>'Profil Berhasil di Perbaharui'], 200);
    }
   public function updatepassword(Request $request)
    {
        $id = auth()->user()->id;
        $validator = Validator::make($request->all(),[
            'old_password'=>'required',
            'password_new'=>'required|min:8',
            'password_confirmation'=>'required_with:password_new|same:password_new|min:8'
        ]);
         if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $user = User::find($id);
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['success'=>false,'message'=>'Password Lama Salah'], 400);
        } else{
            $user->update([
                    "password" => bcrypt($request->password_new)
            ]);
            return response()->json(['success'=>true,'message'=>'Profil Berhasil di Perbaharui'], 200);
        }
        
    }
    public function switch_outlet(Request $request,$id)
    {
       $outlet = Outlet::find($id);
       $merchant_id = "";
       if (!$outlet) {
            return response()->json(['success'=>false,'message'=>'outlet not found'], 400);
       }else{
           $merchant_id = $outlet->merchant_id;
       }
       $user =  UserManajemen::where('user_id',auth()->user()->id)->first();
       $outlet_id = $user->outlet_id;
       $outlet2 = Outlet::find($outlet_id);
       $merchant_id2 = $outlet2->merchant_id;
       if ($merchant_id != $merchant_id2) {
            return response()->json(['success'=>false,'message'=>'outlet not merchant'], 400);
       }
       $swith = UserManajemen::where('id',$user->id)->update([
            'outlet_id'=>$id
       ]);
       return response()->json(['success'=>true,'message'=>'Berhaisl di switch'], 200);

    }
}
