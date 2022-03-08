<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ForgotMail;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function index(Request $request)
    {
       return view('auth.forgot');
    }
    public function check(Request $request)
    {
       $user = User::where('email',$request->email)
            ->where('status',1)
            ->whereIn('role',[11,12,13,14,16])
            ->get();
        if($user->count()==1){
            $this->sendMail($user->first());
        }else{
            return redirect()->route('forgot')->with('error','email tidak terdaftar');

        }
    }
    public function sendMail($user)
    {
         $details = [
            'title' => 'Permintaan Untuk mengganti password '.$user->fullname,
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit deserunt laborum dolores at officia blanditiis commodi cupiditate nobis, totam quibusdam ullam numquam hic dolorem fugiat exercitationem consectetur, quia praesentium quas!'
        ];
        
        try {
            Mail::to($user->email)->send(new ForgotMail($details));
            return redirect()->route('login')->with('message','Link Reset Password Sudah dikirim ke email anda');
        } catch(\Exception $e){
            return redirect()->route('forgot')->with('error','gagal mengirim link ke email anda');

        }
    }

}
