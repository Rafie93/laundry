<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribe\Subscribe;
use App\Models\Subscribe\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Subscription\SubscribeList as ListResource;

class SubscribeController extends Controller
{
    public function history()
    {
        $data = Subscribe::where('user_id', auth()->user()->id)->get();
        return new ListResource($data);

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount'   => 'required',
            'merchant_id' => 'required',
            'package_member_id' => 'required',
            'number' => 'required||unique:subscribe'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $request->merge([
            'date' => date('Y-m-d H:i:s'),
            'user_id' => auth()->user()->id,
            'customer_name' => auth()->user()->fullname,
            'customer_email' => auth()->user()->email,
            'customer_phone' => auth()->user()->phone,
            'status' => 1,
        ]);
        try
        {
            DB::beginTransaction();
                $sale = Subscribe::create($request->all());
            DB::commit();
                $this->_generatePaymentToken($sale);
            return response()->json([
                    'success'=>true,
                    'message'=>'Silahkan Lakukan Proses Pembayaran',
                    'data'=>$sale
                ], 200);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Gagal melakukan transaksi',
                'error' => $e
            ], 400);
        }
    }
    public function _generatePaymentToken($order)
    {
        $this->initPaymentGateway();

		$customerDetails = [
			'first_name' => $order->customer_name,
			'last_name' => $order->customer_name,
			'email' => $order->customer_email,
			'phone' => $order->customer_phone,
		];

		$params = [
			'enable_payments' => \App\Models\Subscribe\Payment::PAYMENT_CHANNELS,
			'transaction_details' => [
				'order_id' => $order->number,
				'gross_amount' => $order->amount,
			],
			'customer_details' => $customerDetails,
			'expiry' => [
				'start_time' => date('Y-m-d H:i:s T'),
				'unit' => \App\Models\Subscribe\Payment::EXPIRY_UNIT,
				'duration' => \App\Models\Subscribe\Payment::EXPIRY_DURATION,
			],
		];

		$snap = \Midtrans\Snap::createTransaction($params);
		
		if ($snap->token) {
			$order->payment_token = $snap->token;
			$order->payment_link = $snap->redirect_url;
			$order->save();
		}
    }
}
