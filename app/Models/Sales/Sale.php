<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\Sale;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        "type_sales",
        "number",
        "date",
        "member_id",
        "store_id",
        "firebase_id",
        "variant_total",
        "shipping_total",
        "tax_total",
        "fee_total",
        "sub_total",
        "discount_total",
        "admin_total",
        "point_total",
        "grand_total",
        "modal_total",
        "payment_method",
        "payment_token",
        "payment_status",
        "payment_link",
        "payment_channel",
        "service",
        "service_type",
        "shipping_method",
        "delivery_to",
        "origin_id",
        "destination_city",
        "postal_code",
        "address",
        "pickup_date",
        "pickup_time",
        "seat_reservation_date",
        "seat_reservation_start",
        "seat_reservation_end",
        "seat",
        "voucher_code",
        "status",
        "notes",
        "customer_name",
        "customer_phone",
        "customer_email",
        "payment_no",
        "payment_expired"
    ];

    public const PAID = 'paid';
	public const UNPAID = 'unpaid';

    public function detail()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function events()
    {
        return $this->hasMany(SalesEvent::class);
    }
    public function is_status()
    {
        return $this->status;
    }
    public function member()
    {
        return $this->belongsTo('App\Models\User','member_id');
    }

    public function stores()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }

    public function destination()
    {
        return $this->belongsTo('App\Models\Regions\City','destination_city');
    }
    public function origin()
    {
        return $this->belongsTo('App\Models\Regions\City','origin_id');
    }

    public static function generateCode($type)
	{
        $code = 'ORD-'; 
        if ($type==3) {
            $code ='TIC';
        }else if ($type==2) {
            $code ='OPS';
        }
		$dateCode = $code.date('Ymd') .integerToRoman(date('m')).integerToRoman(date('d')). '/';
		$lastOrder = self::select([\DB::raw('MAX(sales.number) AS last_code')])
                        ->where('number', 'like', $dateCode . '%')
                        ->first();

		$lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
		
		$orderCode = $dateCode . '00001';
		if ($lastOrderCode) {
			$lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
			$nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
			
			$orderCode = $dateCode . $nextOrderNumber;
		}

		if (self::_isOrderCodeExists($orderCode)) {
			return generateOrderCode();
		}

		return $orderCode;
	}

    private static function _isOrderCodeExists($orderCode)
	{
		return Sale::where('number', '=', $orderCode)->exists();
	}

    public function isPaid()
	{
		return $this->payment_status == self::PAID;
	}
}
