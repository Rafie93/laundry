<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "category";
    protected $fillable = ["name","store_id","status"];
    public function IS_STATUS()
    {
        if ($this->status==1) {
           return "Aktif";
        }else{
            return "Tidak Aktif";
        }
    }
     public function products()
    {
        return $this->hasMany(Product::class);
    }
}
