<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ["outlet_id","category_id","name","price","satuan","icon","deleted","estimasi","estimasi_type"];

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Master\Category');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\Order\OrderDetail','service_id');
    }
}
