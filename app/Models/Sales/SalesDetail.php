<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "store_id",
        "sale_id",
        "product_id",
        "price",
        "price_promo",
        "price_variant",
        "qty",
        "subtotal",
        "notes","type"
    ];

    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }
    public function products()
    {
        return $this->belongsTo("App\Models\Products\Product","product_id");
    }
}
