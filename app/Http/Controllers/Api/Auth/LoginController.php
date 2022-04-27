<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
// use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public $successStatus = 200;

    public function unauthorised(Request $request)
    {
        return response()->json(['success'=>false,'error'=>'Unauthorised'], 401);
    }
    public function checkToken()
    {
        return response()->json(['success'=>true,'message'=>'Token Valid']);
    }
    
   
    public function login(Request $request){
        if(Auth::attempt(['phone' => request('phone'),
             'password' => request('password')])){
            $user = Auth::user();
            if ($user->status==0) {
                return response()->json(['success'=>false,'message'=>'Akun Tidak Ditemuka'], 400);
            }else{
                return new UserResource($user);
            }
        }
        else{
            $cekUser = User::where('phone',$request->phone)->get()->count();
            if($cekUser > 0){
                return response()->json(['success'=>false,'message'=>'Password yang anda masukkan Salah'], 400);
            }
            else{
                return response()->json(['success'=>false,'message'=>'No Telepon yang anda masukkan tidak terdaftar'], 400);
            }
        }


    }
    
 
}
