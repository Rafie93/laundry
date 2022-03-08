<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'email',
        'name',
        'state_id',
        'city_id',
        'district_id',
        'address',
        'latitude',
        'phone',
        'image',
        'longitude',
        'status',
        'logo',
        'slug'
    ];
    public function state()
    {
        return $this->belongsTo('App\Models\Regions\State');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\Regions\City');
    }


    public function logo()
    {
        return $this->logo==null ? 'Tidak Ada Logo' : asset('images/stores').'/'.$this->logo;
    }
    public function IS_STATUS()
    {
        if ($this->status==1) {
           return "Aktif";
        }else{
            return "Tidak Aktif";
        }
    }
}
