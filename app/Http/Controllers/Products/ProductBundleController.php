<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\ProductBundle;
use App\Models\Products\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Image;

class ProductBundleController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $products = Product::orderBy('id','desc')
                        ->where('product_type',2)
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('bundle.index',compact('products'));
    }
    public function create(Request $request)
    {
        $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('product_type',1)
                            ->where('is_ready',1)
                            ->get();
         $categorys = Category::where('store_id',auth()->user()->store_id)
                            ->where('status',1)->get() ;
 
       return view('bundle.create',compact('product','categorys'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:2',
            'category_id'    => 'required',
            'cost_of_goods'=>'numeric',
            'price_sales'=> 'required|numeric',
            'file' => 'required',
            'bundle' => 'required'
        ]);
        $store_id = auth()->user()->store_id;
      
        DB::beginTransaction();
            $productBundle = [];
            foreach ($request->bundle as $i => $bundle) {
                 $productBundle[] = array(
                    "id" => $bundle,
                    "name" => Product::where('id',$bundle)->first()->name,
                    "qty" => $request->qty[$i]
                 );
            }
            $request->merge([
                'store_id' => $store_id,
                'product_type' => 2,
                'createdBy'=>auth()->user()->id,
                'is_ready' => 0,
                'status' => 0,
                'bundle_product' => json_encode($productBundle)
            ]);
            $product = Product::create($request->all());
            if ($request->hasFile('file')) {
                $originName = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileName = $fileName.'_'.time().'.'.$extension;
                $request->file('file')->move('images/product/',$fileName);
                $product->cover = $fileName;
                $product->save();
            }
        DB::commit();
        return redirect()->route('product.bundle')->with('message','Produk Bundle Berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
      
        DB::beginTransaction();
            $productBundle = [];
            foreach ($request->bundle as $i => $bundle) {
                 $productBundle[] = array(
                    "id" => $bundle,
                    "name" => Product::where('id',$bundle)->first()->name,
                    "qty" => $request->qty[$i]
                 );
            }
            $request->merge([
                'createdBy'=>auth()->user()->id,
                'bundle_product' => json_encode($productBundle)
            ]);
            $product = Product::find($id)->update($request->all());
            if ($request->hasFile('file_new')) {
                $originName = $request->file('file_new')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('file_new')->getClientOriginalExtension();
                $fileName = $fileName.'_'.time().'.'.$extension;
                $request->file('fifile_newle')->move('images/product/',$fileName);
                $product->cover = $fileName;
                $product->save();
            }
        DB::commit();
        return redirect()->route('product.bundle')->with('message','Produk Bundle Berhasil ditambahkan');
    }

    public function edit(Request $request,$id)
    {
        $product = Product::where('store_id',auth()->user()->store_id)
                            ->where('status',1)
                            ->where('product_type',1)
                            ->where('is_ready',1)
                            ->get();
        $categorys = Category::where('store_id',auth()->user()->store_id)
                ->where('status',1)->get() ;
        
        $data = Product::find($id);

        return view('bundle.edit',compact('product','categorys','data'));
    }
    public function generate(Request $request,$id)
    {
        $bundle = Product::find($id);
        return view('bundle.generate',compact('bundle'));
    }

    public function generate_voucher(Request $request,$id)
    {

        $this->validate($request,[
            'name' => 'required|min:2',
            'code'    => 'required|unique:product_bundle',
            'price'=> 'required|numeric',
            'quantity' => 'required|numeric',
            'expired' => 'required'
        ]);

        $request->merge([
            'store_id' => auth()->user()->store_id,
            'product_id' => $id
        ]);
        
        ProductBundle::create($request->all());

        $bundle = Product::find($id);
        $bundle->update([
            'is_ready' => 1,
            'status' => 1
        ]);

        return redirect()->route('product.bundle')->with('message','Produk Bundle Berhasil ditambahkan');

    }
}
