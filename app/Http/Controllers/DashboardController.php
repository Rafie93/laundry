<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $role = auth()->user()->role;
        if ($role==12) {
            return view('dashboard.admin');
        }else if ($role==16) {
            return view('dashboard.kurir');
        }
        return view('dashboard.admin');
    }
}
