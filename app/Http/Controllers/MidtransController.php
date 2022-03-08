<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function index()
    {
        $SERVER_KEY = "SB-Mid-server-xIk7aEpPzOX7rNBuXfEjHrQr";
        $IS_PRODUCTTION = false;
        
        $api_url = $IS_PRODUCTTION ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }
}
