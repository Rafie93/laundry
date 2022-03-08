<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductPromo;
use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;

class ProductPromoController extends Controller
{
     public function index(Request $request)
    {
        $promos = ProductPromo::orderBy('id','desc')->paginate(20);
        if (auth()->user()->IN_STORE()) {
            $promos = ProductPromo::orderBy('id','desc')
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('promo.index',compact('promos'));
    }

    public function create(Request $request)
    {
       $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('is_ready',1)
                            ->get();

       return view('promo.create',compact('product'));
    }


    public function edit(Request $request,$id)
    {
       $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('is_ready',1)
                            ->get();
        $data = ProductPromo::find($id);
       return view('promo.edit',compact('product','data'));
    }
    
    public function store(Request $request)
    {
         $this->validate($request,[
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'amount'=> 'required|numeric',
            'product_id'=>'required',
            'type'=>'required'
        ]);
        $store_id = auth()->user()->store_id;
        $request->merge(['store_id'=>auth()->user()->store_id]);
      
        DB::beginTransaction();
         ProductPromo::create($request->all());
        DB::commit();
        return redirect()->route('product.promo')->with('message','Produk Promo Berhasil ditambahkan');
    }

       
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'amount'=> 'required|numeric',
            'product_id'=>'required',
            'type'=>'required'
        ]);
      
        DB::beginTransaction();
            $promo = ProductPromo::find($id);
            $promo->update($request->all());
        DB::commit();
        return redirect()->route('product.promo')->with('message','Produk Promo Berhasil diperbaharui');
    }

}
