<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return new UserResource($user);
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
}
