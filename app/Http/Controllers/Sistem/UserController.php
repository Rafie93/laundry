<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Outlets\Outlet;
use App\Models\Outlets\Merchant;
use App\Models\Users\UserManajemen;
use App\Models\Sistem\PackageMember;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id','desc')
                     ->paginate(10);
        if (!auth()->user()->isSuperAdmin()) {
            $owner = Merchant::where('owner_id',auth()->user()->id)->first();
            $merchant_id = $owner->merchant_id;
            $manajemen = UserManajemen::select('outlet_id')
                            ->where('user_id',auth()->user()->id)->get()->toArray();

            $users = User::select('users.*')->leftJoin('user_manajemen', function($join) {
                            $join->on('users.id', '=', 'user_manajemen.user_id');
                         })
                         ->whereIn('user_manajemen.outlet_id', [$manajemen])
                         ->orderBy('id','desc')
                         ->paginate(10);
        }
        
        return view('users.index',compact('users'));
    }

    public function create(Request $request)
    {           
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();
        if ($owner) {
            $stores = Outlet::where('status',1)
                        ->where('merchant_id',$owner->id)->get();
        }else{
            $stores = Outlet::where('status',1)->get();
        }
        

       return view('users.create',compact('stores'));
    }

    public function edit(Request $request,$id)
    {
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();
        if ($owner) {
            $stores = Outlet::where('status',1)
                        ->where('merchant_id',$owner->id)->get();
        }else{
            $stores = Outlet::where('status',1)->get();
        }
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
        
        if ($request->role==1) {
            $users = User::create($request->all());
        }else{
            if (auth()->user()->role!=2 ){
                return redirect()->route('user')->with('message','Anda Bukan Owner, Tidak Bisa Menambahkan User');
            }
            $owner = Merchant::where('owner_id',auth()->user()->id)->first();
            if ($owner) {
               $packageId = $owner->package_member_id;
               $paket  = PackageMember::where('id',$packageId)->first();
               $cashier = $paket->cashier == null ? 999999999 : $paket->cashier;
               $outlet = Outlet::where('merchant_id',$owner->id)->get()->toArray();
               $count = UserManajemen::whereIn('outlet_id',$outlet)->get()->count();
               if ($count>=$cashier+1) {
                    return redirect()->route('user')->with('message','Maksimal Kasir Sebanyak '.$cashier);
               }
            }
            $users = User::create($request->all());
            UserManajemen::create([
                'user_id' => $users->id,
                'role' => $request->role,
                'outlet_id' => $request->outlet_id,
                'status' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        

        return redirect()->route('user')->with('message','User Baru Berhasil ditambahkan');
    }
     public function update(Request $request,$id)
    {
        $this->validate($request,[
            'fullname' => 'required|min:2',
            'email'    => 'required',
            'phone'=>'required',
        ]);
        if ($request->password_change!="") {
            $request->merge(['password'=>bcrypt($request->password_change)]);
        }
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('user')->with('message','User Baru Berhasil diperbaharui');
    }
}
