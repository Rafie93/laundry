<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Outlets\Merchant;
use  App\Models\User;
use App\Models\Subscribe\Subscribe;
use  App\Models\Outlets\Outlet;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $role = auth()->user()->role;
        $totalBerlangganan = Merchant::where('package_member_id','<>',1)->count();
        $totalBelumBerlangganan = Merchant::where('package_member_id',1)->count();

        $totalOutlet = Outlet::where('status',1)->count();
        $totalUser = User::where('role','<>',1)->count();
        if ($role==12) {
            return view('dashboard.admin',compact('totalBerlangganan','totalUser','totalOutlet','totalBelumBerlangganan'));
        }else if ($role==16) {
            return view('dashboard.kurir');
        }
        return view('dashboard.admin',compact('totalBerlangganan','totalUser','totalOutlet','totalBelumBerlangganan'));
    }
}
