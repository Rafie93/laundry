<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales\Sale;
use App\Models\Sales\SalesDetail;
use App\Models\Sales\Payment;
class PaymentController extends Controller
{

    public function notification(Request $request)
	{
		$payload = $request->getContent();
		$notification = json_decode($payload);

		$validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

		if ($notification->signature_key != $validSignatureKey) {
			return response(['message' => 'Invalid signature'], 403);
		}

		$this->initPaymentGateway();
		$statusCode = null;

		$paymentNotification = new \Midtrans\Notification();
		$order = Sale::where('number', $paymentNotification->order_id)->firstOrFail();

		if ($order->isPaid()) {
			return response(['message' => 'The order has been paid before'], 422);
		}

		$transaction = $paymentNotification->transaction_status;
		$type = $paymentNotification->payment_type;
		$orderId = $paymentNotification->order_id;
		$fraud = $paymentNotification->fraud_status;

		$vaNumber = null;
		$vendorName = null;
		if (!empty($paymentNotification->va_numbers[0])) {
			$vaNumber = $paymentNotification->va_numbers[0]->va_number;
			$vendorName = $paymentNotification->va_numbers[0]->bank;
		}

		$paymentStatus = null;
		if ($transaction == 'capture') {
			// For credit card transaction, we need to check whether transaction is challenge by FDS or not
			if ($type == 'credit_card') {
				if ($fraud == 'challenge') {
					// TODO set payment status in merchant's database to 'Challenge by FDS'
					// TODO merchant should decide whether this transaction is authorized or not in MAP
					$paymentStatus = Payment::CHALLENGE;
				} else {
					// TODO set payment status in merchant's database to 'Success'
					$paymentStatus = Payment::SUCCESS;
				}
			}
		} else if ($transaction == 'settlement') {
			// TODO set payment status in merchant's database to 'Settlement'
			$paymentStatus = Payment::SETTLEMENT;
		} else if ($transaction == 'pending') {
			// TODO set payment status in merchant's database to 'Pending'
			$paymentStatus = Payment::PENDING;
		} else if ($transaction == 'deny') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = PAYMENT::DENY;
		} else if ($transaction == 'expire') {
			// TODO set payment status in merchant's database to 'expire'
			$paymentStatus = PAYMENT::EXPIRE;
		} else if ($transaction == 'cancel') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = PAYMENT::CANCEL;
		}

		$paymentParams = [
			'sales_id' => $order->id,
			'number' => Payment::generateCode(),
			'amount' => $paymentNotification->gross_amount,
			'method' => 'midtrans',
			'status' => $paymentStatus,
			'token' => $paymentNotification->transaction_id,
			'payloads' => $payload,
			'payment_type' => $paymentNotification->payment_type,
			'va_number' => $vaNumber,
			'vendor_name' => $vendorName,
			'biller_code' => $paymentNotification->biller_code,
			'bill_key' => $paymentNotification->bill_key,
		];

		$payment = Payment::create($paymentParams);
		if ($paymentStatus && $payment) {
			\DB::transaction(
				function () use ($order, $payment) {
					if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
						$order->payment_status = 'paid';
						$order->status = 2;
						$order->save();
						//
						$firebase = $this->initFirebase();
						$sale = Sale::where('id', $order->id)->first();
						if ($order->type_sales != 3) {
							$salesDetail = SalesDetail::where('sale_id',$order->id)->get();
							$menu_product_name ="";
							foreach ($salesDetail as $detail) {
								$menu_product_name .= $detail->qty." x ".$detail->products->name."\n";
							}
							$postData = [
								"id" =>$order->id,
								"store_name" => $order->stores->name,
								"number" =>$order->number,
								"customer_id" => $order->member_id,
								"customer_name" => $order->member->fullname,
								"date" =>  $order->created_at->format('D, d M Y : H:i:s'),
								"grand_total" => $order->grand_total,
								"menu_name" => $menu_product_name,
								"service"=> $order->service,
								"status"=> 'Prepare Order',
								"payment_status" => $order->payment_status,
								"payment_method" => $order->payment_method
							];
							$updates = ['orders/store-'.$sale->store_id.'/'.$sale->firebase_id => $postData];
							$firebase->getReference()->update($updates);
						}
						$title = "Transaction ".$sale->number." (PAID)";
						$body  = $title." ".$sale->member->fullname." Baru Saja Melakukan Pembayaran via ".$sale->payment_method." Sebesar Rp ".number_format($order->grand_total);
						sendFirebaseToAdminStore($sale->store_id,$title,$body);
						$notifFirebaseData = [
							"title" => $title,
							"body" => $body,
							"from" => $sale->member_id,
							"to" => $sale->store_id,
							"code" => $sale->number,
							"type" => "sales",
							"is_read" => "belum",
							"time" => $sale->updated_at
						];
						$firebase->getReference('notification/store-'.$sale->store_id)->push($notifFirebaseData);
						
					}
				}
			);
		}

		if ($paymentStatus == PAYMENT::EXPIRE || $paymentStatus == PAYMENT::CANCEL ) {
			$order->payment_status = 'unpaid';
			$order->status = 6;
			$order->save();
			//
			if ($order->type_sales != 3) {
				$sale = Sale::where('id', $order->id)->first();
				$salesDetail = SalesDetail::where('sale_id',$order->id)->get();
				$menu_product_name ="";
				foreach ($salesDetail as $detail) {
					$menu_product_name .= $detail->qty." x ".$detail->products->name."\n";
				}
				$postData = [
					"id" =>$order->id,
					"store_name" => $order->stores->name,
					"number" =>$order->number,
					"customer_id" => $order->member_id,
					"customer_name" => $order->member->fullname,
					"date" =>  $order->created_at->format('D, d M Y : H:i:s'),
					"grand_total" => $order->grand_total,
					"menu_name" => $menu_product_name,
					"service"=> $order->service,
					"status"=> 'Canceled',
					"payment_status" => $order->payment_status,
					"payment_method" => $order->payment_method
				];
				$firebase = $this->initFirebase();
				$updates = ['orders/store-'.$sale->store_id.'/'.$sale->firebase_id => $postData];
				$firebase->getReference()->update($updates);
			}
		}

		$message = 'Payment status is : '. $paymentStatus;

		$response = [
			'code' => 200,
			'message' => $message,
		];

		return response($response, 200);
	}

	/**
	 * Show completed payment status
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function completed(Request $request)
	{
		$code = $request->query('order_id');
		$order = Sale::where('number', $code)->firstOrFail();
		
		if ($order->payment_status == Order::UNPAID) {
			// return redirect('payments/failed?order_id='. $code);
		}

		\Session::flash('success', "Thank you for completing the payment process!");

		// return redirect('orders/received/'. $order->id);
	}

	/**
	 * Show unfinish payment page
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function unfinish(Request $request)
	{
		$code = $request->query('order_id');
		$order = Order::where('code', $code)->firstOrFail();

		\Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect('orders/received/'. $order->id);
	}

	/**
	 * Show failed payment page
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function failed(Request $request)
	{
		$code = $request->query('order_id');
		$order = Order::where('code', $code)->firstOrFail();

		\Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect('orders/received/'. $order->id);
	}
}
