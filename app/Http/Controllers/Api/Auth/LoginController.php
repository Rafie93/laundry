<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
    
    public function mail(Request $request)
    {
        $this->clearLoginAttempts($request);

        if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'role'=>15,'status'=>1])){
            $user = Auth::user();
            return new UserResource($user);
        }else if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'role'=>15,'status'=>1])){
            $user = Auth::user();
            return new UserResource($user);
        }
        else{
            $cekUser = User::where('email',$request->email)->get()->count();
            if($cekUser > 0){
                return response()->json(['success'=>false,'message'=>'Password yang anda masukkan Salah'], 400);
            }
            else{
                return response()->json(['success'=>false,'message'=>'email yang anda masukkan tidak terdaftar'], 400);
            }
        }
    }
    public function phone(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'phone'   => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $user = User::where("phone",$request->phone)->where('status',1)->where('role',15)->get();
        if ($user->count() != 1) {
           return response()->json(['success'=>false,'message'=>'Akun tidak ditemukan, silahkan daftar terlebih dulu'], 400);
        }
        $otp = generateOTP();
        $currentDateTime = Carbon::now();
        $otpExpired = Carbon::now()->addMinute(2);

        $user = $user->first();
        $user->update([
            'otp' => $otp,
            'otp_expired' => $otpExpired
        ]);
        $message = "JANGAN BERIKAN kode OTP ini ke SIAPAPUN termasuk pihak cs. \nOTP anda: ".$otp;
        nascondimiSendMessage($request->phone,$message);
        return response()->json(['success'=>true,'message'=>'Kami Mengirimkan kode OTP ke no whatshapp anda, mohon Verifikasi'], 200);
    }
    public function otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp'   => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $valid = User::where('phone',$request->phone)
                    ->where('otp',$request->otp)
                    ->where('status',1)
                    ->where('role',15)
                    ->get();
        if($valid->count() == 1){
            $user = $valid->first();
            Auth::loginUsingId($user->id);
            $user->update([
                'otp' => null,
                'otp_expired' => null
            ]);
            return new UserResource($user);
        }
        else{
            return response()->json(array("errors"=>array("attribute"=>"otp","message"=>"OTP Salah")), 422);
        }
    }
}
