<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = "order_detail";
    protected $fillable = ["order_id","service_id","qty","price","sub_total","estimasi","estimasi_type"];

    public function service()
    {
        return $this->belongsTo('App\Models\Master\Service','service_id');
    }
}
