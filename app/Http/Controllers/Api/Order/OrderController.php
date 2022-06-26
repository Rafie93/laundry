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

                    $detail = new \App\Models\Order\OrderDetail;
                    $detail->order_id = $order->id;
                    $detail->service_id = $service_id;
                    $detail->qty = $qty;
                    $detail->price = $price;
                    $detail->sub_total =$price* $qty;
                    $detail->save();
                }

               $det = OrderDetail::where('order_id',$order->id)->get();
               $sId = 0;
               foreach ($det as $row) {
                  $sId = $row->service_id;
               }
               $service = Service::find($sId)->first();
               if ($service) {
                    $est = $service->estimasi;
                    $estimasi_type = $service->estimasi_type;
                    if ($estimasi_type=="Hari") {
                        $estimasi = Carbon::now()->addDays($est);
                        Order::find($order->id)->update([
                            'date_estimasi' => $estimasi
                        ]);
                    }else{
                        $estimasi = Carbon::now()->addHour($est);
                        Order::find($order->id)->update([
                            'date_estimasi' => $estimasi
                        ]);
                    }
                }
                
            DB::commit();
            return response()->json([
                'success'=>true,
                'message'=>'Pesanan Berhasil Dibuat',
                'data' =>new ItemResource($order),
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
