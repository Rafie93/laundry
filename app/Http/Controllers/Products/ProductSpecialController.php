<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductSpecial;
use App\Models\Products\Product;
use App\Models\Regions\City;
use Illuminate\Support\Facades\DB;


class ProductSpecialController extends Controller
{
     public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $specials = ProductSpecial::orderBy('id','desc')
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('special.index',compact('specials'));
    }

    public function create(Request $request)
    {
       $product_id = ProductSpecial::select('product_id')
                        ->where('store_id',auth()->user()->store_id)
                        ->get()
                        ->toArray();
       $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('product_type',1)
                            ->where('is_ready',1)
                            ->whereNotIn('id',$product_id)
                            ->get();

       return view('special.create',compact('product'));
    }

    public function edit(Request $request,$id)
    {
        $data = ProductSpecial::find($id);
        $product_id = ProductSpecial::select('product_id')
                        ->where('store_id',auth()->user()->store_id)
                        ->get()
                        ->toArray();
        $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('product_type',1)
                            ->where('is_ready',1)
                            ->whereNotIn('id',$product_id)
                            ->get();

       return view('special.edit',compact('product','data'));
    }

    public function store(Request $request)
    {
         $this->validate($request,[
            'city_id' => 'required',
            'khas' => 'required'
        ]);
        $store_id = auth()->user()->store_id;

        $citys = City::where('id',$request->city_id)->first();
      
        DB::beginTransaction();
            foreach ($request->khas as $i => $khas) {
                $request->merge([
                    'store_id' => $store_id,
                    'keyword_city' => $citys->name,
                    'state_id' => $citys->province_id,
                    'status'=>1,
                    'product_id' => $khas
                ]);
                ProductSpecial::create($request->all());
            }
        DB::commit();
        return redirect()->route('product.special')->with('message','Produk Special / Khas Berhasil ditambahkan');
    }


}
