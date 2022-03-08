<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = "product_image";
    protected $fillable = ["image","store_id","product_id"];

    function images()
    {
        return $this->image==null ? 'Tidak Ada Image' : asset('/storage/images/product/'.$this->store_id.'/'.$this->product_id.'/'.$this->image);
    }
}
