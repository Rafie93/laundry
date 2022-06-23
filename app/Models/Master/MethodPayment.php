<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodPayment extends Model
{
    use HasFactory;
    protected $table = "method_payment";
    protected $fillable = ["type","name","logo","outlet_id"];

    public function images()
    {
        return $this->logo==null ? "" : asset('images/method/'.$this->logo);
    }
    
    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }
}
