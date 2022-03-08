<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sales\Sale;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $member_id = Sale::select('member_id')
                        ->where('store_id',auth()->user()->store_id)
                        ->get()
                        ->toArray();
                        
            $users = User::where('role',15)
                        ->whereIn('id',$member_id)
                        ->paginate(20);
        }else{
             $users = User::orderBy('id','desc')
                        ->where('role',15)
                        ->paginate(20);
        }
        return view('member.index',compact('users'));
    }
}
