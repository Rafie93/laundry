<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Register;
use App\Models\User;
class RegisterController extends Controller
{
    public function phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'   => 'required|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $otp = generateOTP();
        $request->merge([
            'otp' => $otp,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        Register::updateOrInsert([
            'phone' => $request->phone
        ],$request->all());
        $message = "JANGAN BERIKAN kode OTP ini ke SIAPAPUN termasuk pihak cs. \nOTP anda: ".$otp;
        nascondimiSendMessage($request->phone,$message);
        return response()->json(['success'=>true,'message'=>'Kami Mengirimkan kode OTP ke no whatshapp anda, mohon Verifikasi'], 200);
    }
    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp'   => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $valid = Register::where('phone',$request->phone)
                    ->where('otp',$request->otp)
                    ->get();
        if ($valid->count() == 1) {
            $register = $valid->first();
            User::create([
                'phone' => $request->phone,
                'fullname' => '-',
                'email' => '@gmail.com',
                'status' => 1,
                'role' => 15,
                'password' => bcrypt($request->phone),
                'created_at' => \Carbon\Carbon::now(),
            ]);
            $register->update([
                'otp' => null
            ]);
            return response()->json(['success'=>true,'message'=>'Registrasi Sukses, Silahkan lengkapi profil akun anda'], 200);
        }else{
            return response()->json(array("errors"=>array("attribute"=>"otp","message"=>"OTP Salah")), 422);
        }
    }


}
