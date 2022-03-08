<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Stores\Store;
use App\Models\Products\ProductVariant;
use App\Models\Products\ProductImage;
use Image;
use Illuminate\Support\Facades\DB;


class ProductMasterController extends Controller
{
    public function index(Request $request)
    {
       $products =
              Product::where('type','2')->where('product_type',1)
                 ->select('name','code','category_id','description','price_sales','status','is_ready')
                 ->groupBy('name','code','category_id','description','price_sales','status','is_ready')
                 ->paginate(10);
                 
        return view('productmerchant.index',compact('products'));
    }

    public function create(Request $request)
    {
       $categorys = Category::where('status',1)->get() ;
       $stores = Store::where('status',1)->get();
       return view('productmerchant.create',compact('categorys','stores'));
    }

    public function edit(Request $request,$id)
    {
       $categorys = Category::where('status',1)->get() ;
       $stores = Store::where('status',1)->get();
       $data = Product::where('code',$id)->first(); 
       return view('productmerchant.edit',compact('categorys','stores','data'));
    }
     public function delete(Request $request,$id)
    {
        $data = Product::where('code',$id)->where('type',2)->get();
        $totalData = $data->count();
        $deleteTotal = 0;
        foreach ($data as $row) {
            if ($row->sales->count() == 0) {
                 Product::find($row->id)->delete();
                 $deleteTotal++;
            }
        }
        if ($deleteTotal==$totalData) {
            return redirect()->route('products')->with('message','Data Produk dihapus');
        } 
        return redirect()->route('products')->with('error','Data Produk Tidak semua store dihapus');
      
    }

    public function review(Request $request,$id)
    {
       $data = Product::where('code',$id)->first(); 
       return view('productmerchant.detail',compact('data'));
    }

    public function detail(Request $request,$id)
    {
       $data = Product::where('code',$id)->first(); 
       $variants = ProductVariant::where('product_id',$data->id)->get();
       $images = ProductImage::where('product_id',$data->id)->get();
       return view('productmerchant.detail',compact('data','variants','images'));
    }

    public function store(Request $request)
    {
         $this->validate($request,[
            'name' => 'required|min:2',
            'code'=>'required',
            'category_id'    => 'required',
            'cost_of_goods'=>'numeric',
            'price_sales'=> 'required|numeric',
            'store'=>'required'
        ]);
        $request->merge(['is_ready'=>1,'type'=>2,'createdBy'=>auth()->user()->id]);
        foreach ($request->store as $i => $store) {
            $store_id = $request->store[$i];
            $request->merge(['store_id'=> $store_id]);
            DB::beginTransaction();
                $product = Product::create($request->all());
                $product_id = $product->id;

                if ($request->hasFile('file')) {
                    $originName = $request->file('file')->getClientOriginalName();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $fileName = $fileName.'_'.time().'.'.$extension;
                    $request->file('file')->move('images/product/',$fileName);
                    $product->cover = $fileName;
                    $product->save();
                }

                if($request->variant!=0){
                    $optionsVariant = [];
                        foreach ($request->name_pilihan as $i => $name) {
                            $optionsVariant[] = array(
                                    "name" => $name,
                                    "price" => $request->price_pilihan[$i],
                                    "sequence" => $request->urutan[$i]
                            );
                        } 
                    ProductVariant::create([
                        'store_id' => $store_id,
                        "product_id" => $product_id,
                        'type' => $request->variant,
                        'name' => '-',
                        'options'=>  json_encode($optionsVariant)
                    ]);
                }
                if($request->imagecount > 0){
                    foreach ($request->images as $i => $images) {
                        $request->merge(['product_id' => $product_id,'images' => $images]);
                        $productImage = ProductImage::create($request->all());
                        if ($request->hasFile('images')) {
                            $originName1 = $request->file('images')->getClientOriginalName();
                            $fileName1 = pathinfo($originName1, PATHINFO_FILENAME);
                            $extension1 = $request->file('images')->getClientOriginalExtension();
                            $fileName1 = $fileName1.'_'.time().'.'.$extension1;
                            $request->file('images')->move('images/product/',$fileName1);
                            $productImage->image = $fileName1;
                            $productImage->save();
                        }
                    }
                }
            DB::commit();
        }
       
         return redirect()->route('products')->with('message','Produk Berhasil di tambahkan');
    }
}
