<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Order\OrderList as ListResource;
use App\Http\Resources\Order\OrderItem as ItemResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Order::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->where(function ($query) {
                            if (auth()->user()->role == 4 ){
                                $query->where('creator_id','=', auth()->user()->id);
                            }
                        })
                        ->get();

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
                $macamService = count($prodserviceArrayukArray);
                for ($i=0; $i < $macamProduk; $i++) {
                    $service_id = $produkArray[$i]["service_id"];
                    $price = $produkArray[$i]['price'];
                    $qty = $produkArray[$i]['qty'];

                    $detail = new \App\Models\Order\OrderDetail;
                    $detail->order_id = $order->id;
                    $detail->service_id = $service_id;
                    $detail->qty = $qty;
                    $detail->price = $price;
                    $detail->sub_total =$price* $qty;
                    $detail->save();
                }
            DB::commit();
            return response()->json([
                'success'=>true,
                'message'=>'Pesanan Berhasil Dibuat',
                'data' => ItemResource($order),
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
