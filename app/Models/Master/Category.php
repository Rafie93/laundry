<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "category";
    protected $fillable = ["outlet_id","name","deleted"];

    public function outlet()
    {
        return $this->belongsTo('App\Models\Outlets\Outlet');
    }

    public function service()
    {
        return $this->hasMany('App\Models\Master\Service','category_id');
    }
}
