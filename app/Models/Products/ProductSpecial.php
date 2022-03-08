<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecial extends Model
{
    use HasFactory;
    protected $fillable = ["product_id","city_id","keyword_city","state_id","status","store_id"];

     public function is_status()
    {
        if ($this->status==1) {
           return "Aktif";
        }else{
            return "Tidak Aktif";
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

     public function state()
    {
        return $this->belongsTo('App\Models\Regions\State');
    }
    public function store()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\Regions\City');
    }



}
