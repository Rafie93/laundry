<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = "user_address";
    protected $fillable = [
        'user_id',
        'city_id',
        'district_id',
        'district_name',
        'address',
        'postalcode',
        'latitude',
        'longitude',
        'is_main'
    ];

    public function city()
    {
        return $this->belongsTo('App\Models\Regions\City');
    }
}
