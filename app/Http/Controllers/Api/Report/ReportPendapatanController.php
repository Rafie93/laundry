<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use App\Models\Expenditure\Expenditure;
use Illuminate\Support\Facades\DB;
Use App\Models\Users\UserManajemen;

class ReportPendapatanController extends Controller
{
    public function ringkasan(Request $request)
    {
        $outlet_id = $request->outlet_id;
        $start = $request->start ? $request->start : date('Y-m-d');
        $end = $request->end ? $request->end : date('Y-m-d');
        $type = $request->type;
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
            $outlet_id = $user->outlet_id;
        }

        if ($type=="Keuangan") {
            $lunas = Order::where('status_payment',1)
                                ->where('status_order','<>',4)
                                ->where('outlet_id',$outlet_id)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('date_pay', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('date_pay', '<=', "{$request->end}");
                                })
                                ->sum('grand_total');

            $pengambilan = Order::where('status_payment',0)
                                ->where('status_order','<>',4)
                                ->where('outlet_id',$outlet_id)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('date_pay', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('date_pay', '<=', "{$request->end}");
                                })
                                ->sum('grand_total');

            $diskon = Order::where('status_order','<>',4)
                                ->where('outlet_id',$outlet_id)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('date_pay', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('date_pay', '<=', "{$request->end}");
                                })
                                ->sum('discount');


            // PENGELUARAN
            $pengeluaran = Expenditure::when($request->start, function ($query) use ($request) {
                                    $query->whereDate('date', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('date', '<=', "{$request->end}");
                                })
                                ->where('outlet_id',$outlet_id)
                                ->sum('cost');

            $pengeluaranDetail = Expenditure::select('expenditure_category.name',DB::raw("SUM(expenditure.cost) as nominal"))
                                ->groupBy('expenditure_category.name')
                                ->leftJoin('expenditure_category', 'expenditure_category.id', '=', 'expenditure.expenditure_category_id')
                                ->where('expenditure.outlet_id',$outlet_id)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('expenditure.date', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('expenditure.date', '<=', "{$request->end}");
                                })
                                ->get();

            $pendapatan[] = array(
                'name' => 'Pendapatan (Lunas)',
                'nominal' => strval(number_format($lunas)),
            );
            $pendapatan[] = array(
                'name' => 'Pendapatan (Pengambilan)',
                'nominal' => strval(number_format($pengambilan)),
            );
            $pendapatan[] = array(
                'name' => 'Diskon',
                'nominal' => strval(number_format($diskon)),
            );

            $output[] = array(
                'category' => 'Pendapatan',
                'nominal' => $lunas+$pengambilan,
                'data' => $pendapatan
            );

            //PENGELUARAN

            $peng = array();
            foreach ($pengeluaranDetail as $p) {
                $peng[] = array(
                    "name" => $p->name,
                    "nominal" => number_format($p->nominal)
                );
            }

            $output[] = array(
                'category' => 'Pengeluaran',
                'nominal' => $pengeluaran,
                'data' => $peng
            );
                
            return response()->json($output);

        }else if($type=="Transaksi"){
            $masuk = Order::whereIn('status_order',[0,1,2])
                            ->where('outlet_id',$outlet_id)
                            ->when($request->start, function ($query) use ($request) {
                                $query->whereDate('date_entry', '>=', "{$request->start}");
                            })
                            ->when($request->end, function ($query) use ($request) {
                                $query->whereDate('date_entry', '<=', "{$request->end}");
                            })
                            ->count();

            $batal = Order::where('status_order',4)
                    ->where('outlet_id',$outlet_id)
                    ->when($request->start, function ($query) use ($request) {
                        $query->whereDate('date_entry', '>=', "{$request->start}");
                    })
                    ->when($request->end, function ($query) use ($request) {
                        $query->whereDate('date_entry', '<=', "{$request->end}");
                    })
                    ->count();


            $metodeDetail = Order::select('metode_payment as name',DB::raw(" concat(cast(count(*) as char), ' transaksi') as nominal"))
                    ->groupBy('metode_payment')
                    ->where('outlet_id',$outlet_id)
                    ->when($request->start, function ($query) use ($request) {
                        $query->whereDate('date_pay', '>=', "{$request->start}");
                    })
                    ->when($request->end, function ($query) use ($request) {
                        $query->whereDate('date_pay', '<=', "{$request->end}");
                    })
                    ->get();
                    

            $layanan[] = array(
                'name' => 'Transaksi Masuk',
                'nominal' => strval($masuk)." Transaksi.",
            );
            $layanan[] = array(
                'name' => 'Transaksi Batal',
                'nominal' => strval($batal)." Transaksi.",
            );
            

            $output[] = array(
                'category' => 'Layanan',
                'nominal' => $masuk - $batal,
                'data' => $layanan
            );

            //metode

            $output[] = array(
                'category' => 'Metode Pembayaran',
                'nominal' => $metodeDetail->count(),
                'data' => $metodeDetail
            );
                
            return response()->json($output);


        }else if($type=="Produksi"){
            $metodeDetail = OrderDetail::select('services.satuan as name',DB::raw("SUM(order_detail.qty) as nominal"))
                                ->groupBy('services.satuan')
                                ->leftJoin('services', 'services.id', '=', 'order_detail.service_id')
                                ->leftJoin('order', 'order.id', '=', 'order_detail.order_id')
                                ->where('order.outlet_id',$outlet_id)
                                ->where('order.status_order','<>',4)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('order.date_entry', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('order.date_entry', '<=', "{$request->end}");
                                })
                                ->get();
            
            $mDout=array();
            foreach ($metodeDetail as $key => $md) {
                $mNominal = round($md->nominal,2);
                $mDout[] = array(
                    'name' => $md->name,
                    'nominal' => number_format($mNominal)
                );
            }

            $output[] = array(
                'category' => 'Produksi',
                'nominal' => $metodeDetail->count(),
                'data' => $metodeDetail
            );
                
            return response()->json($output);

        }

    }

    public function pendapatan(Request $request)
    {
        $outlet_id = $request->outlet_id;
        $start = $request->start ? $request->start : date('Y-m-d');
        $end = $request->end ? $request->end : date('Y-m-d');
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
            $outlet_id = $user->outlet_id;
        }
        
        $data = Order::select('order.number','customer.name as customer','order.date_pay as date',
                                DB::raw("SUM(order.grand_total) as nominal"))
                                ->groupBy('order.number','customer.name','order.date_pay')
                                ->leftJoin('customer', 'customer.id', '=', 'order.customer_id')
                                ->where('order.outlet_id',$outlet_id)
                                ->where('order.status_payment',1)
                                ->where('order.status_order','<>',4)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('order.date_pay', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('order.date_pay', '<=', "{$request->end}");
                                })
                                ->get();

        $output = array(
            'success' => true,
            'total' => $data->sum('nominal'),
            'jumlah' => $data->count(),
            'data' => $data
        );
            
        return response()->json($output);
                    
    }
    public function metode(Request $request)
    {
        $outlet_id = $request->outlet_id;
        $start = $request->start ? $request->start : date('Y-m-d');
        $end = $request->end ? $request->end : date('Y-m-d');
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
            $outlet_id = $user->outlet_id;
        }
        
        $data = Order::select('order.metode_payment as name',
                                DB::raw("SUM(order.grand_total) as nominal"))
                                ->groupBy('order.metode_payment')
                                ->where('order.outlet_id',$outlet_id)
                                ->where('order.status_payment',1)
                                ->where('order.status_order','<>',4)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('order.date_pay', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('order.date_pay', '<=', "{$request->end}");
                                })
                                ->get();

        $tunai = Order::where('outlet_id',$outlet_id)
                        ->where('status_payment',1)
                        ->where('status_order','<>',4)
                        ->where('metode_payment','Tunai')
                        ->when($request->start, function ($query) use ($request) {
                            $query->whereDate('date_pay', '>=', "{$request->start}");
                        })
                        ->when($request->end, function ($query) use ($request) {
                            $query->whereDate('date_pay', '<=', "{$request->end}");
                        })
                        ->sum('grand_total');

        $transfer = Order::select('order.grand_total')
                        ->leftJoin('method_payment','method_payment.name','=','order.metode_payment')
                        ->where('method_payment.outlet_id',$outlet_id)
                        ->where('method_payment.type','Transfer')
                        ->where('order.outlet_id',$outlet_id)
                        ->where('order.status_payment',1)
                        ->where('order.status_order','<>',4)
                        ->when($request->start, function ($query) use ($request) {
                            $query->whereDate('order.date_pay', '>=', "{$request->start}");
                        })
                        ->when($request->end, function ($query) use ($request) {
                            $query->whereDate('order.date_pay', '<=', "{$request->end}");
                        })
                        ->sum('grand_total');


        $wallet = Order::select('order.grand_total')
                        ->leftJoin('method_payment','method_payment.name','=','order.metode_payment')
                        ->where('method_payment.outlet_id',$outlet_id)
                        ->where('method_payment.type','E-Wallet')
                        ->where('order.outlet_id',$outlet_id)
                        ->where('order.status_payment',1)
                        ->where('order.status_order','<>',4)
                        ->when($request->start, function ($query) use ($request) {
                            $query->whereDate('order.date_pay', '>=', "{$request->start}");
                        })
                        ->when($request->end, function ($query) use ($request) {
                            $query->whereDate('order.date_pay', '<=', "{$request->end}");
                        })
                        ->sum('grand_total');

        $output = array(
            'success' => true,
            'total' => strval($data->sum('nominal')),
            'tunai' => strval($tunai),
            'transfer' => strval($transfer),
            'wallet' => strval($wallet),
            'data' => $data
        );
            
        return response()->json($output);
                    
    }

    public function layanan(Request $request)
    {
        $outlet_id = $request->outlet_id;
        $start = $request->start ? $request->start : date('Y-m-d');
        $end = $request->end ? $request->end : date('Y-m-d');
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
            $outlet_id = $user->outlet_id;
        }

        $data = OrderDetail::select('services.name as name',
                                 DB::raw("COUNT('order_detail.id') as transaksi, 
                                 SUM(`order_detail`.`sub_total`) as nominal"),
                            )
                            ->groupBy('services.name')
                            ->leftJoin('services', 'services.id', '=', 'order_detail.service_id')
                            ->leftJoin('order', 'order.id', '=', 'order_detail.order_id')
                            ->where('order.outlet_id',$outlet_id)
                            ->where('order.status_order','<>',4)
                            ->when($request->start, function ($query) use ($request) {
                                $query->whereDate('order.date_entry', '>=', "{$request->start}");
                            })
                            ->when($request->end, function ($query) use ($request) {
                                $query->whereDate('order.date_entry', '<=', "{$request->end}");
                            })
                            ->get();


        $output = array(
            'success' => true,
            'total' => $data->sum('nominal'),
            'data' => $data
        );
            
        return response()->json($output);
    }

    public function pelanggan(Request $request)
    {
        $outlet_id = $request->outlet_id;
        $start = $request->start ? $request->start : date('Y-m-d');
        $end = $request->end ? $request->end : date('Y-m-d');
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
            $outlet_id = $user->outlet_id;
        }

        $data = Order::select('customer.name as name',
                                 DB::raw("COUNT('order.id') as transaksi, 
                                 SUM(`order`.`grand_total`) as nominal"),
                            )
                            ->groupBy('customer.name')
                            ->leftJoin('customer', 'customer.id', '=', 'order.customer_id')
                            ->where('order.outlet_id',$outlet_id)
                            ->where('order.status_order','<>',4)
                            ->when($request->start, function ($query) use ($request) {
                                $query->whereDate('order.date_entry', '>=', "{$request->start}");
                            })
                            ->when($request->end, function ($query) use ($request) {
                                $query->whereDate('order.date_entry', '<=', "{$request->end}");
                            })
                            ->get();


        $output = array(
            'success' => true,
            'total' => $data->sum('nominal'),
            'transaksi' => $data->sum('transaksi'),
            'pelanggan' => $data->count(),
            'data' => $data
        );
            
        return response()->json($output);
    }
}
