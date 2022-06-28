<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    protected $table = "promo";
    protected $fillable = ["outlet_id","name","type","amount","date_start","date_end","description"];
}
