<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\Product;
class ProductPairing extends Model
{
    use HasFactory;
    protected $table = "product_pairing";
    protected $fillable = [
        "store_id",
        "product_id",
        "product_pairing",
        "status"
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

    public function getPairing() 
    {
        $pairings = json_decode($this->product_pairing,true);
        return $pairings;
    }

    public function getProductId($productId)
    {
       return Product::find($productId);
    }

}
