<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stores\Store;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id','desc')
                        ->whereIn('role',[11,12,13,14,16])
                        ->paginate(10);
        if (auth()->user()->IN_STORE()) {
            $users = User::orderBy('id','desc')
                        ->whereIn('role',[12,13,14,16])
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }
        return view('users.index',compact('users'));
    }

    public function create(Request $request)
    {
       $stores = Store::where('status',1)->get();
       return view('users.create',compact('stores'));
    }

    public function edit(Request $request,$id)
    {
       $stores = Store::where('status',1)->get();
       $data = User::find($id);
       return view('users.edit',compact('stores','data'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'fullname' => 'required|min:2',
            'email'    => 'required|unique:users',
            'phone'=>'required',
            'password'=>'required|min:8',
            'repassword'=>'required_with:password|same:password|min:8'
        ]);
        
        $request->merge(['password'=>bcrypt($request->password)]);
        if (auth()->user()->role!=11) {
            $request->merge(['store_id'=>auth()->user()->store_id]);
        }

        User::create($request->all());
        return redirect()->route('user')->with('message','User Baru Berhasil ditambahkan');
    }
     public function update(Request $request,$id)
    {
        $this->validate($request,[
            'fullname' => 'required|min:2',
            'email'    => 'required|unique:users.'.$id,
            'phone'=>'required',
        ]);
        if ($request->password_old!="") {
            $request->merge(['password'=>bcrypt($request->password_old)]);
        }
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('user')->with('message','User Baru Berhasil diperbaharui');
    }
}
