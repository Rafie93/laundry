<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $data = auth()->user();
        return view('users.profile',compact('data'));
    }
    public function change(Request $request)
    {
        $data = auth()->user();
        return view('users.profile-change',compact('data'));
    }
    public function update(Request $request)
    {
        $id = auth()->user()->id;
        $this->validate($request,[
            'fullname' => 'required|min:2',
            'phone'=>'required',
            'birthday'=>'date'
        ]);
        $user = User::find($id);
        $user->update([
            "fullname" => $request->fullname,
            'phone'=> $request->phone,
            'birthday'=>$request->birthday,
            'gender' => $request->gender
        ]);
        return redirect()->route('myprofile')->with('message','Profile Baru Berhasil diperbaharui');
    }
    public function resetpassword(Request $request)
    {
       return view('users.profile-password');
    }
    public function updatepassword(Request $request)
    {
        $id = auth()->user()->id;
        $this->validate($request,[
            'old_password'=>'required',
            'password_new'=>'required|min:8',
            'password_confirmation'=>'required_with:password_new|same:password_new|min:8'
        ]);
        $user = User::find($id);
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'The specified password does not match the database password');
        } else{
            $user->update([
                    "password" => bcrypt($request->password_new)
            ]);
            return redirect()->route('myprofile')->with('message','Password Baru Berhasil diperbaharui');
        }
        
    }
}
