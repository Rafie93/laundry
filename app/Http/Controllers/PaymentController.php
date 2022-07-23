<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe\Subscribe;
use App\Models\Subscribe\Payment;
use App\Models\Sistem\PackageMember;
use App\Models\Outlets\Merchant;

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
		$order = Subscribe::where('number', $paymentNotification->order_id)->firstOrFail();

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

						$package_member_id = $order->package_member_id;
						$merchant_id = $order->merchant_id;
						$package_member = PackageMember::find($package_member_id);
						if ($package_member) {
							$durasi = $package_member->duration;
							$durasi_day = $package_member->duration_day;
							if ($duration_day=="day") {
								Merchant::where('id', $merchant_id)
										->update([
											'expired' => \Carbon\Carbon::now()->addDays($durasi)
										]);
							}else if ($duration_day=="month") {
								Merchant::where('id', $merchant_id)
										->update([
										'expired' => \Carbon\Carbon::now()->addMonth($durasi)
								]);
							}else if ($duration_day=="year") {
								Merchant::where('id', $merchant_id)
										->update([
										'expired' => \Carbon\Carbon::now()->addYear($durasi)
								]);
							}
						}
					}
				}
			);
		}

		if ($paymentStatus == PAYMENT::EXPIRE || $paymentStatus == PAYMENT::CANCEL ) {
			$order->payment_status = 'unpaid';
			$order->status = 6;
			$order->save();			
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
		$data = Subscribe::where('number', $code)->firstOrFail();
		
		if ($data->payment_status == "UNPAID") {
			return view('midtrans.completed',compact('data'));
		}
 
		return view('midtrans.completed',compact('data'));
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
		$data = Subscribe::where('number', $code)->firstOrFail();
		return view('midtrans.failed',compact('data'));
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
		$data = Subscribe::where('number', $code)->firstOrFail();
		return view('midtrans.failed',compact('data'));
	}
}
