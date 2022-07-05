<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Expenditure\Expenditure;
Use App\Models\Users\UserManajemen;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
        $outlet_id = $user->outlet_id;

        $pendapatan = Order::whereDate('date_pay',date('Y-m-d'))
                            ->where('status_payment',1)
                            ->where('status_order','<>',4)
                            ->sum('grand_total');
        $pengeluaran = Expenditure::where('creator_id',auth()->user()->id)
                            ->whereDate('date',date('Y-m-d'))
                            ->sum('cost');

        $orderIn = Order::where('outlet_id',$outlet_id)
                            ->where('status_order',0)
                            // ->whereDate('date_entry',date('Y-m-d'))
                            ->count();

        $orderProses = Order::where('outlet_id',$outlet_id)
                            ->where('status_order',1)
                            // ->whereDate('date_process',date('Y-m-d'))
                            ->count();

        $orderWait = Order::where('outlet_id',$outlet_id)
                            ->where('status_order',2)
                            // ->whereDate('date_taken',date('Y-m-d'))
                            ->count();

        $orderDone = Order::where('outlet_id',$outlet_id)
                            ->where('status_order',3)
                            // ->whereDate('date_complete',date('Y-m-d'))
                            ->count();

        return response()->json([
            'success'=>true,
            'pendapatan' => intval($pendapatan),
            'pengeluaran' => intval($pengeluaran),
            'order_masuk' => intval($orderIn),
            'order_proses' => intval($orderProses),
            'order_wait' => intval($orderWait),
            'order_done' => intval($orderDone),
        ], 200);
    }
}
