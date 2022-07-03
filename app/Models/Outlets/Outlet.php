<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    protected $table = "outlet";
    protected $fillable = ["merchant_id","name","code","phone","email","city_id","district_id","address",
    "logo","is_show_logo","margin_receipt","footnote",
    "latitude","longitude","slug","status"];

    public function isLogo()
    {
        return $this->logo==null ? null : asset('images/logo-outlet/'.$this->logo);
    }

    public function merchant()
    {
        return $this->belongsTo('App\Models\Outlets\Merchant');
    }
}
