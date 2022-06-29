<?php

namespace App\Http\Controllers\Api\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Outlets\Outlet;
use App\Models\Outlets\Merchant;
use App\Models\Users\UserManajemen;
use App\Http\Resources\User as UserItem;
use App\Http\Resources\UserList as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistem\PackageMember;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isSuperAdmin() && auth()->user()->isOwner()) {
            $owner = Merchant::where('owner_id',auth()->user()->id)->first();
            $merchant_id = $owner->merchant_id;
            $manajemen = UserManajemen::select('outlet_id')
                            ->where('user_id',auth()->user()->id)->get()->toArray();

            $users = User::select('users.*')->leftJoin('user_manajemen', function($join) {
                            $join->on('users.id', '=', 'user_manajemen.user_id');
                         })
                         ->where('users.status',1)
                         ->whereIn('user_manajemen.outlet_id', [$manajemen])
                         ->orderBy('id','desc')
                         ->get();

            return new UserResource($users);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Hak Akses Tidak Diizinkan'
            ],400);
        }
    }
    public function store(Request $request)
    {
        if (auth()->user()->role!=2 ){
            return response()->json(['success'=>false,'message'=>'Anda Bukan Owner'], 400);
        }
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:2',
            'email'    => 'required|unique:users',
            'phone'=>'required|unique:users',
            'outlet_id' => 'required',
            'role' => 'required',
            'password'=>'required|min:8',
            'repassword'=>'required_with:password|same:password|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();
        if ($owner) {
            $packageId = $owner->package_member_id;
            $paket  = PackageMember::where('id',$packageId)->first();
            $cashier = $paket->cashier == null ? 999999999 : $paket->cashier;
            $outlet = Outlet::where('merchant_id',$owner->id)->get()->toArray();
            $count = UserManajemen::whereIn('outlet_id',$outlet)->get()->count();
            if ($count>=$cashier+1) {
                return response()->json([
                    'status' => true,
                    'message' => 'Maksimal Kasir Sebanyak '.$cashier,
                ],500); 
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
        
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menambahkan User',
        ],200);    
    }
    public function update(Request $request,$id)
    {
        if (auth()->user()->role!=2 ){
            return response()->json(['success'=>false,'message'=>'Anda Bukan Owner'], 400);
        }
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:2',
            'outlet_id' => 'required',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }

        if ($request->password_change!="") {
            $request->merge(['password'=>bcrypt($request->password)]);
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
        $users = User::find($id);
        $users->update($request->all());
        UserManajemen::where('user_id',$id)
            ->update([
            'role' => $request->role,
            'outlet_id' => $request->outlet_id,
            'status' => 1,
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menambahkan User',
        ],200);    
    }
    public function delete(Request $request,$id)
    {
        if (auth()->user()->role!=2 ){
            return response()->json(['success'=>false,'message'=>'Anda Bukan Owner'], 400);
        }
        $users = User::find($id);
        if ($users->role==1 || $users->role==2) {
            return response()->json(['success'=>false,'message'=>'Data User ini tidak dapat dihapus'], 400);
        }
        $users->update([
            'status' => 0,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menghapus Data User',
        ],200);   
    }
}
