<?php

namespace App\Http\Controllers\Api\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Order\OrderList as ListResource;
use App\Http\Resources\Order\OrderItem as ItemResource;

class RincianPelangganController extends Controller
{
    public function index(Request $request,$id)
    {
        $total_transaksi = Order::where('customer_id',$id)->get()->count();
        $total_nominal = Order::where('status_order','<>',4)
                                ->where('status_payment',1)
                                ->where('customer_id',$id)
                                ->sum('grand_total');
        $total_utang = Order::where('status_order','<>',4)
                                ->where('status_payment',0)
                                ->where('customer_id',$id)
                                ->sum('grand_total');

        $output = array(
                    'total_transaksi' => strval($total_transaksi),
                    'total_nominal' => strval($total_nominal),
                    'total_utang' => strval($total_utang)
                );
                                    
        return response()->json($output);

    }
    public function transaksi(Request $request,$id)
    {
        $data = Order::where('customer_id',$id)->get();
        return new ListResource($data);
    }
    public function nominal(Request $request,$id)
    {
        $data = Order::where('status_order','<>',4)
                        ->where('status_payment',1)
                        ->where('customer_id',$id)
                        ->get();
        return new ListResource($data);
    }
    public function utang(Request $request,$id)
    {
        $data = Order::where('status_order','<>',4)
                        ->where('status_payment',0)
                        ->where('customer_id',$id)
                        ->get();
        return new ListResource($data);
    }
}
