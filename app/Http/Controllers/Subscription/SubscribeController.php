<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribe\Subscribe;

class SubscribeController extends Controller
{
    public function index(Request $request)
    {
        $subscribes = Subscribe::orderBy('created_at','desc')
                                ->where(function ($query) {
                                    if (!auth()->user()->isSuperAdmin() ){
                                        $query->where('user_id','=', auth()->user()->id);
                                    }
                                }) 
                                ->paginate(20);
        return view('subscription.index', compact('subscribes'));
    }

    public function detail(Request $request,$id)
    {
        $data = Subscribe::find($id);
        return view('subscription.detail', compact('data'));
    }
}
