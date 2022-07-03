<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "order";
    protected $fillable = ["outlet_id",
    "number", 
    "customer_id",
    "date_entry", 
    "date_estimasi",
    "date_process",
    "date_complete", 
    "date_taken", 
    "date_canceled",
    "date_pay", 
    "subtotal", 
    "discount", 
    "additional_cost", 
    "is_discount", 
    "nominal_discount", 
    "discount_type", 
    "grand_total", 
    "estimated_time", 
    "estimated_type", 
    "parfume", 
    "rak", 
    "voucher_user", 
    "notes", 
    "is_down_payment", 
    "nominal_down_payment", 
    "remainder", 
    "metode_payment", 
    "status_payment", 
    "status_order", 
    "items", 
    "alasan",
    "creator_id"];

    public function isStatusPayment()
    {
        return $this->status_payment == 1 ? 'Lunas' : 'Belum Lunas';
    }

    public function isStatusOrder()
    {
      switch ($this->status_order) {
        case 1:
            return "Diproses";
            break;
        case 2:
            return "Tunggu diambil";
            break;
        case 3:
            return "Selesai";
            break;
        case 4:
            return "Batal";
            break;
        default:
            return "Masuk";
            break;
      }
    }


    public function customer()
    {
        return $this->belongsTo('App\Models\Outlets\Customer','customer_id');
    }
    public function creator()
    {
        return $this->belongsTo('App\Models\User','creator_id','id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Models\Order\OrderDetail', 'order_id');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }
}
