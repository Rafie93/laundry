<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\ProductPairing;
use App\Models\Products\Product;
use Illuminate\Support\Facades\DB;

class ProductPairingController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $pairings = ProductPairing::orderBy('id','desc')
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('pairing.index',compact('pairings'));
    }

    public function create(Request $request)
    {
       $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('product_type',1)
                            ->where('is_ready',1)
                            ->get();

       return view('pairing.create',compact('product'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'product_id' => 'required|unique:product_pairing',
            'pairing' => 'required'
        ]);
        $store_id = auth()->user()->store_id;
      
        DB::beginTransaction();
            $productPairing = [];
            foreach ($request->pairing as $i => $pair) {
                 $productPairing[] = array(
                    "product_id" => $pair
                 );
            }
            $request->merge([
                'store_id' => $store_id,
                'product_pairing' => json_encode($productPairing)
            ]);
            ProductPairing::create($request->all());

        DB::commit();
        return redirect()->route('pairing')->with('message','Produk Pairing Berhasil ditambahkan');
    }
    
}
