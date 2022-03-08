<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;
    protected $table = "rak";
    protected $fillable = ["outlet_id","name"];

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }
}
