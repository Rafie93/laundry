<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPromo extends Model
{
    use HasFactory;
    protected $table = "product_promo";
    protected $fillable = [
        'store_id',
        'product_id',
        'code',
        'type',         
        'amount',
        'start_date',
        'end_date',
        'status'
    ];
     public function product()
    {
        return $this->belongsTo(Product::class);
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
