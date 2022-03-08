<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    protected $table = "outlet";
    protected $fillable = ["merchant_id","name","code","phone","email","city_id","district_id","address","logo","latitude","longitude","slug","status"];

    public function merchant()
    {
        return $this->belongsTo('App\Models\Outlets\Merchant');
    }
}
