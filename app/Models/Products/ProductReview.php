<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_id",
        "reviews",
        "rating"
    ];
     public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
