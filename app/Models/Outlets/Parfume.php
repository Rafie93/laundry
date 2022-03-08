<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parfume extends Model
{
    use HasFactory;
    protected $table = "parfume";
    protected $fillable = ["outlet_id","name","price"];
    
    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }
}
