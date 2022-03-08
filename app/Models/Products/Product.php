<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stores\Store;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'product_type',
        'name',
        'code',
        'description',
        'category_id',
        'cost_of_goods',
        'price_sales',
        'is_ready',
        'is_show_menu',
        'is_ppn',
        'cover',
        'status',
        'type',
        'createdBy',
        'point_cashback',
        'time_duration',
        'is_stock',
        'long_delivery',
        'weight',
        'bundle_product'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
     public function stores()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }
    public function sales()
    {
        return $this->hasMany('App\Models\Sales\SalesDetail');
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function pairings()
    {
        return $this->hasMany(ProductPairing::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cover()
    {
        return $this->cover==null ? 'Tidak Ada Image' : asset('images/product/'.$this->cover);
    }
    public function IS_STATUS()
    {
        if ($this->status==1) {
           return "Aktif";
        }else{
            return "Tidak Aktif";
        }
    }
     public function IS_STOCK()
    {
        if ($this->is_stock==1) {
           return "YA";
        }else{
            return "Tidak";
        }
    }
     public function LONG_DELIVERY()
    {
        if ($this->long_delivery==1) {
           return "YA";
        }else{
            return "Tidak";
        }
    }
      public function DisplayStatus()
    {
         if ($this->status==1) {
           return '<span class="badge badge-pill badge-success">Aktif</span>';
        }else{
            return '<span class="badge badge-pill badge-danger">Tidak Aktif</span>';
        }
    }
    public function SHOW_MENU()
    {
        if ($this->is_show_menu==1) {
           return "Tampil";
        }else{
            return "Tidak Tampil";
        }
    }
    public function IS_PPN()
    {
        if ($this->is_ppn==1) {
           return "Ya";
        }else{
            return "Tidak";
        }
    }
    public function READY()
    {
        if ($this->is_ready==1) {
           return "Tersedia";
        }else{
            return "Tidak Tersedia";
        }
    }
    
    public function DisplayReady()
    {
        if ($this->is_ready==1) {
           return '<span class="badge badge-pill badge-success">Available</span>';
        }else{
            return '<span class="badge badge-pill badge-danger">Not Available</span>';
        }
    }

    public function getProductByCode($code)
    {
        return Product::where('code',$code);
    }

     public function coverProductMerchant($code)
    {
        $prod = Product::where('code',$code)->first();
        $storeId = $prod->store_id;
        $cover = $prod->cover;
        return $cover==null ? 'Tidak Ada Image' : asset('/storage/images/product/'.$storeId.'/'.$prod->id.'/'.$cover);
    }

    public function storeAvailables($code)
    {
      $storeId =  Product::select('store_id')->where('type',2)->where('code',$code)->get()->toArray();
      return Store::whereIn('id',$storeId)->get();
    }

    public function productAvailableStore($code)
    {
    //   $storeId =  Product::select('store_id')->where('type',2)->where('code',$code)->get()->toArray();
      return Product::where('code',$code)->where('type',2)->get();
    }

    public function productFromStore($code,$name)
    {
    //   $storeId =  Product::select('store_id')->where('type',2)->where('code',$code)->get()->toArray();
      return Product::where('code',$code)->where('name',$name)->where('type',1)->get();
    }

    public function variant()
    {
        
    }
}
