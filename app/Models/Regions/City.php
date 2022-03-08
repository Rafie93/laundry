<?php

namespace App\Models\Regions;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $fillable = ['id','province_id','name',"province","type","postal_code"];
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
