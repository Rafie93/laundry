<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;

Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Order\OrderList as ListResource;
use App\Http\Resources\Order\OrderItem as ItemResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Master\Service;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ? $request->status : 0;
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
        if ($status==0) {
            $data = Order::orderBy('date_estimasi','asc')
                            ->where('outlet_id',$user->outlet_id)
                            ->where('status_order',$status)
                            ->where(function ($query) {
                                if (auth()->user()->role == 4 ){
                                    $query->where('creator_id','=', auth()->user()->id);
                                }
                            })
                            ->get();
        }else if ($status==1) {
            $data = Order::orderBy('date_process','asc')
                            ->where('outlet_id',$user->outlet_id)
                            ->where('status_order',$status)
                            ->where(function ($query) {
                                if (auth()->user()->role == 4 ){
                                    $query->where('creator_id','=', auth()->user()->id);
                                }
                            })
                            ->get();
        }else if ($status==2) {
            $data = Order::orderBy('date_taken','desc')
                            ->where('outlet_id',$user->outlet_id)
                            ->where('status_order',$status)
                            ->where(function ($query) {
                                if (auth()->user()->role == 4 ){
                                    $query->where('creator_id','=', auth()->user()->id);
                                }
                            })
                            ->get();
        }else if ($status==2) {
            $data = Order::orderBy('date_complete','desc')
                            ->where('outlet_id',$user->outlet_id)
                            ->where('status_order',$status)
                            ->where(function ($query) {
                                if (auth()->user()->role == 4 ){
                                    $query->where('creator_id','=', auth()->user()->id);
                                }
                            })
                            ->get();
        }else{
            $data = Order::orderBy('id','desc')
                    ->where('outlet_id',$user->outlet_id)
                    ->where('status_order',$status)
                    ->where(function ($query) {
                        if (auth()->user()->role == 4 ){
                            $query->where('creator_id','=', auth()->user()->id);
                        }
                    })
            ->get();
        }
        

        return new ListResource($data);
    }
    public function detail(Request $request,$number)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Order::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->where('number',$number)
                        ->first();
        if ($data) {
            return new ItemResource($data);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ],400);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|unique:order',
            'grand_total' => 'required|numeric',
            'services' => 'required|json',
            'customer_id' => 'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $request->merge([
            'creator_id'=>auth()->user()->id,
            'date_entry' => Carbon::now(),

        ]);
        if ($request->status_payment==1) {
            $request->merge([
                'date_pay' => Carbon::now(),
            ]);
        }
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();                            
           $request->merge(['outlet_id'=>$user->outlet_id]);
        }
        try
        {
            DB::beginTransaction();
                $order = Order::create($request->all());
                $serviceArray = json_decode($request->services, true);
                $macamService = count($serviceArray);
                for ($i=0; $i < $macamService; $i++) {
                    $service_id = $serviceArray[$i]["service_id"];
                    $price = $serviceArray[$i]['price'];
                    $qty = $serviceArray[$i]['qty'];

                    $myService = Service::where('id',$service_id)->first();
                
                    $detail = new \App\Models\Order\OrderDetail;
                    $detail->order_id = $order->id;
                    $detail->service_id = $service_id;
                    $detail->qty = $qty;
                    $detail->price = $price;
                    $detail->sub_total =$price* $qty;
                    if ($myService) {
                        $detail->estimasi = $myService->estimasi;
                        $detail->estimasi_type = $myService->estimasi_type;

                    }
                    $detail->save();
                }

               $det = OrderDetail::orderBy('estimasi_type','asc')
                                    ->orderBy('estimasi','desc')
                                    ->where('order_id',$order->id)
                                    ->first();
               $sId = $det->service_id;
               $service = Service::where('id',$sId)->first();
               if ($service) {
                    $est = $service->estimasi;
                    $estimasi_type = $service->estimasi_type;
                    if ($estimasi_type=="Hari") {
                        $estimasi = Carbon::now()->addDays($est);
                        Order::find($order->id)->update([
                            'date_estimasi' => $estimasi,
                            'estimated_time' => $est,
                            'estimated_type' => $estimasi_type
                        ]);
                    }else{
                        $estimasi = Carbon::now()->addHour($est);
                        Order::find($order->id)->update([
                            'date_estimasi' => $estimasi,
                            'estimated_time' => $est,
                            'estimated_type' => $estimasi_type
                        ]);
                    }
                }
                
            DB::commit();
            $orderResponse = Order::where('id',$order->id)->first();
            if ($orderResponse) {
                $customerPhone = $orderResponse->customer->phone;
                $outletName = $orderResponse->outlet->name;
                $message = "Outlet ".$outletName."\n\nInformasi Transaksi\nNomor Pesanan : "
                .$orderResponse->number."\nTanggal Masuk : "
                .$orderResponse->date_entry."\nNama Pelanggan : ".$orderResponse->customer->name."\n\nInformasi Pembayaran\nStatus Pembayaran : "
                .$orderResponse->isStatusPayment()."\nGrand Total : ".$orderResponse->grand_total."\n\n\nSalam Juragan Kasir Laundry";

                sendMessage($customerPhone,$message);
            }
            return response()->json([
                'success'=>true,
                'message'=>'Pesanan Berhasil Dibuat',
                'data' =>new ItemResource($orderResponse),
            ], 200);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Gagal melakukan pembuatan Pesanan',
                'error' => $e
            ], 400);
        }
        return response()->json(['success'=>true,'message'=>'Pesanan Laundry Berhasil dibuat'], 200);
    }

    public function batalkan_order(Request $request,$number)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                         ->where('status',1)
                        ->first();

        $orderData =  Order::where('number',$number)
                    ->where('outlet_id',$user->outlet_id)
                    ->first();
        if (!$orderData) {
            return response()->json(['success'=>false,'message'=>'Pesanan tidak ditemukan'], 400);
        }else{
            if ($orderData->status_order == 3 || $orderData->status_order == 4) {
                return response()->json(['success'=>false,'message'=>'Pesanan sudah diselesaikan'], 400);
            }else{
                $request->merge([
                    'status_order' => 4,
                    'date_canceled' => Carbon::now()
                ]);
                Order::where('number',$number)->update($request->all());
                return response()->json([
                    'success'=>true,
                   'message'=>'Pesanan Berhasil dibatalkan'
               ], 200);
            }
        }
    }

    public function pay_transaction(Request $request,$number)
    {
        $validator = Validator::make($request->all(), [
            'metode_payment' => 'required'
        ]);

        $user = UserManajemen::where('user_id',auth()->user()->id)
                         ->where('status',1)
                        ->first();

        $orderData =  Order::where('number',$number)
                    ->where('outlet_id',$user->outlet_id)
                    ->first();
        if (!$orderData) {
            return response()->json(['success'=>false,'message'=>'Pesanan tidak ditemukan'], 400);
        }else{
            if ($orderData->status_payment == 1) {
                return response()->json(['success'=>false,'message'=>'Pesanan sudah terbayarkan'], 400);
            }else{
                $request->merge([
                    'status_payment' => 1,
                    'date_pay' => Carbon::now()
                ]);
                Order::where('number',$number)->update($request->all());
                return response()->json([
                    'success'=>true,
                   'message'=>'Pesanan Berhasil dibayar'
               ], 200);
            }
        }
    }

    public function update_status_order(Request $request,$number)
    {
        $validator = Validator::make($request->all(), [
            'status_order' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();

        $orderData =  Order::where('number',$number)
                                ->where('outlet_id',$user->outlet_id)
                                ->first();
        if (!$orderData) {
            return response()->json(['success'=>false,'message'=>'Pesanan tidak ditemukan'], 400);
        }else{
            if ($orderData->status_order == 3 || $orderData->status_order == 4) {
                return response()->json(['success'=>false,'message'=>'Pesanan sudah diselesaikan'], 400);
            }else{
                if ($request->status_order==1) {
                    $request->merge([
                        'date_process' => Carbon::now(),
                    ]);
                 }else if ($request->status_order==2) {
                     $request->merge([
                         'date_taken' => Carbon::now(),
                     ]);
                     if ($orderData) {
                         $customerPhone = $orderData->customer->phone;
                         $outletName = $orderData->outlet->name;
                         $message = "Outlet ".$outletName."\n\nNomor Pesanan : ".$orderData->number."\nSudah Bisa Diambil Di Outlet\n\nSalam Juragan Kasir Laundry";
                         sendMessage($customerPhone,$message);
                     }
                 }else if ($request->status_order==3) {
                     $request->merge([
                         'date_complete' => Carbon::now(),
                     ]);
                 }
                 Order::where('number',$number)->update($request->all());
                 return response()->json([
                     'success'=>true,
                    'message'=>'Status Pesanan Berhasil diperbaharui'
                ], 200);

            }
        }  
    }
    
}
