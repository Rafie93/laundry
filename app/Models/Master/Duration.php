<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;
    protected $table = "duration";
    protected $fillable = ["outlet_id","type","time"];
    
    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }
}
