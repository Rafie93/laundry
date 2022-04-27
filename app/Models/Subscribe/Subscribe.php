<?php

namespace App\Models\Subscribe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;
    protected $table = "subscribe";
    protected $fillable = ["number","merchant_id","user_id","package_member_id","amount","status","date","payment_link","payment_status","payment_token","customer_name","customer_phone","customer_email"];
    public const PAID = 'paid';
	public const UNPAID = 'unpaid';

	public function package()
    {
        return $this->belongsTo('App\Models\Sistem\PackageMember','package_member_id');
    }
	public function merchant()
    {
        return $this->belongsTo('App\Models\Outlets\Merchant','merchant_id');
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
		$lastOrder = self::select([\DB::raw('MAX(subscribe.number) AS last_code')])
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
		return Subscribe::where('number', '=', $orderCode)->exists();
	}

    public function isPaid()
	{
		return $this->payment_status == self::PAID;
	}
}
