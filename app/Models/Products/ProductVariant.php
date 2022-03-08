<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = "product_variant";
    protected $fillable = ["store_id","product_id","name","type","options"];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function is_type()
    {
        
        if ($this->type==1) {
           return "Pilih satu";
        }else{
            return "Pilih Banyak";
        }
    }

     public function getOptions() //pengirim
    {
        $options = json_decode($this->options,true);
        return $options;
    }

}
