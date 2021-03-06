<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use App\Models\Outlets\Merchant;
use App\Models\Sistem\PackageMember;
use App\Models\Outlets\Outlet;
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
        $out_id = $request->outlet_id;
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();                            
           $request->merge(['outlet_id'=>$user->outlet_id]);
           $out_id = $user->outlet_id;
        }
        $merchantId = Outlet::where('id',$out_id)->first()->merchant_id;
        $owner = Merchant::where('id',$merchantId)->first();
        $auto_send_wa = "No";
        if ($owner) {
            $packageId = $owner->package_member_id;
            $expired = $owner->expired;
            $is_expired = false;

            $paket  = PackageMember::where('id',$packageId)->first();
            $maks_transaksi = $paket->maks_transaksi == null ? 999999999 : $paket->maks_transaksi;
            $auto_send_wa = $paket->auto_send_nota;

            $awal  = date_create($expired);
            $akhir = date_create(); 
            $diff  = date_diff( $awal, $akhir );
            if ($akhir > $awal) {
                $maks_transaksi = 5;
                $is_expired = true;
            }

            $outlet = Outlet::select('id')->where('merchant_id',$owner->id)->get()->toArray();
            $count = Order::whereIn('outlet_id',$outlet)
                            ->whereDate('date_entry',date('Y-m-d'))
                            ->get()
                            ->count();

            if ($is_expired) {
                if ($count >= $maks_transaksi) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Paket Berlangganan Anda habis, silahkan upgrade untuk melakukan transaksi harian lebih banyak',
                    ],400); 
                }
            }else{
                if ($count >= $maks_transaksi) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Upgrade Paket Berlangganan Anda, untuk dapat melakukan transaksi harian lebih banyak',
                    ],400); 
                }
            }
            
        }
        $request->merge([
            'creator_id'=>auth()->user()->id,
            'date_entry' => Carbon::now(),
            'notes' => $request->note,
        ]);
        if ($request->status_payment==1) {
            $request->merge([
                'date_pay' => Carbon::now(),
            ]);
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
            if ($orderResponse && $auto_send_wa=="Yes") {
                $customerPhone = $orderResponse->customer->phone;
                $outletName = $orderResponse->outlet->name;
                $outletPhone = $orderResponse->outlet->phone;
                $outletaddress = $orderResponse->outlet->address;

                $detail = OrderDetail::where('order_id',$order->id)->get();
                $messageDetail = "\n";
                foreach ($detail as $det) {
                    $messageDetail .= $det->service->name;
                    $messageDetail .= "\n".$det->qty." x ".number_format($det->price)." = ".number_format($det->sub_total)."\n";
                }

                $message = "Outlet :".$outletName
                ."\nTelp : ".$outletPhone
                ."\nAlamat : ".$outletaddress
                ."\n\nInformasi Transaksi\nNomor Pesanan : "
                .$orderResponse->number."\nTanggal Masuk : "
                .$orderResponse->date_entry
                ."\nTanggal Estimasi : ".$orderResponse->date_estimasi
                ."\nNama Pelanggan : ".$orderResponse->customer->name
                ."\n\n===================="
                .$messageDetail
                ."\n\n===================="
                ."\n\nInformasi Pembayaran\nStatus Pembayaran : "
                .$orderResponse->isStatusPayment()."\nGrand Total : ".$orderResponse->grand_total
                ."\n\nInformasi Lainnya"
                ."\nNote : ".$orderResponse->notes
                ."\nParfume : ".$orderResponse->parfume
                ."\n\n\nSalam Juragan Kasir Laundry";

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
                $orderResponse = Order::where('number',$number)->first();
                if ($orderResponse) {
                    $customerPhone = $orderResponse->customer->phone;
                    $outletName = $orderResponse->outlet->name;
                    $outletPhone = $orderResponse->outlet->phone;
    
                    $message = "Outlet :".$outletName."\nTelp : ".$outletPhone."\n\nInformasi Transaksi\nNomor Pesanan : "
                    .$orderResponse->number."\nTanggal Masuk : "
                    .$orderResponse->date_entry."\nNama Pelanggan : ".$orderResponse->customer->name."\n\nInformasi Pembayaran\nStatus Pembayaran : "
                    .$orderResponse->isStatusPayment()."\nTanggal Bayar : ".$orderResponse->date_pay."\nGrand Total : ".$orderResponse->grand_total."\n\n\nSalam Juragan Kasir Laundry";
    
                    sendMessage($customerPhone,$message);
                }
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
                         $outletPhone = $orderData->outlet->phone;
                         $outletAddress = $orderData->outlet->address;

                         $message = "Outlet : ".$outletName."\nTelp : ".$outletPhone."\n\nNomor Pesanan : ".$orderData->number."\nSudah Bisa Diambil Di Outlet ".$outletName." ".$outletAddress."\n\nSalam Juragan Kasir Laundry";
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
