<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = "satuan";
    protected $fillable = ["outlet_id","name","alias"];

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }
}
