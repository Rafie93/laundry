<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Products\ProductVariant;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductPairing;
use App\Models\Products\ProductSpecial;
use App\Models\Products\ProductPromo;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->IN_STORE()) {
            $products = Product::orderBy('id','desc')
                        ->where('product_type',1)
                        ->where('store_id',auth()->user()->store_id)
                        ->paginate(10);
        }

        return view('products.index',compact('products'));
    }

    public function create(Request $request)
    {
       $categorys = Category::where('store_id',auth()->user()->store_id)
                            ->where('status',1)->get() ;
       return view('products.create',compact('categorys'));
    }

    public function edit(Request $request,$id)
    {
       $categorys = Category::where('store_id',auth()->user()->store_id)
                            ->where('status',1)->get() ;
        $data = Product::find($id);
       return view('products.edit',compact('categorys','data'));
    }

    public function review(Request $request,$id)
    {
       $data = Product::where('id',$id)->first(); 
       $variants = ProductVariant::where('product_id',$id)->get();
       $images = ProductImage::where('product_id',$id)->get();
       return view('products.review',compact('data','variants','images'));
    }
    public function detail(Request $request,$id)
    {
       $data = Product::where('id',$id)->first(); 
       $variants = ProductVariant::where('product_id',$id)->get();
       $images = ProductImage::where('product_id',$id)->get();
       return view('products.detail',compact('data','variants','images'));
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move('images/product/',$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/product/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function store(Request $request)
    {
         $this->validate($request,[
            'name' => 'required|min:2',
            'category_id'    => 'required',
            'cost_of_goods'=>'numeric',
            'price_sales'=> 'required|numeric',
            'file' => 'required'
        ]);
        $store_id = auth()->user()->store_id;
        $request->merge([
            'is_ready'=>0,
            'status'=>0,
            'store_id'=>$store_id,
            'createdBy'=>auth()->user()->id
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
        return redirect()->route('product.review',$product->id)->with('message','Review Produk yang akan di tambahkan');
    }

    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'name' => 'required|min:2',
            'category_id'    => 'required',
            'cost_of_goods'=>'numeric',
            'price_sales'=> 'required|numeric'
        ]);
        $product = Product::find($id);
        $product->update($request->all());
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/product/',$fileName);
            $product->cover = $fileName;
            $product->save();
       }
        return redirect()->route('product.review',$product->id)->with('message','Produk berhasil diperbaharui');
    }


    public function variant(Request $request,$id)
    {
       $this->validate($request,[
            'name' => 'required',
            'type'    => 'required'
        ]);
        $store_id = auth()->user()->store_id;
        $optionsVariant = [];
        foreach ($request->name_pilihan as $i => $name) {
            $optionsVariant[] = array(
                    "name" => $name,
                    "price" => $request->price_sales[$i],
                    "sequence" => $request->urutan[$i]
            );
        } 
       $request->merge([
           'product_id' => $id,
           'store_id' => $store_id,
           'options' => json_encode($optionsVariant)
       ]);
       DB::beginTransaction();
            ProductVariant::create($request->all());
       DB::commit();
       return redirect()->route('product.review',$id)->with('message','Produk Variant berhasil di tambahkan');
    }

    public function images(Request $request,$id)
    {
        $this->validate($request,[
            'file' => 'required'
        ]);
        $store_id = auth()->user()->store_id;
        $request->merge([
           'product_id' => $id,
           'store_id' => $store_id,
       ]);

        $productImage = ProductImage::create($request->all());
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/product/',$fileName);
            $productImage->image = $fileName;
            $productImage->save();
        }
        return redirect()->route('product.review',$id)->with('message','Gambar Telah berhasil di tambahkan');

    }

    public function submit(Request $request,$id)
    {
        Product::where('id',$id)->update(['is_ready'=>1,'status'=>1]);
        return redirect()->route('product')->with('message','Produk Sudah Ready / Tersedia');
    }

    public function delete($id)
    {
       $prod = Product::find($id);
       if ($prod->sales->count() == 0) {
           DB::beginTransaction();
               ProductVariant::where('product_id',$id)->where('store_id',auth()->user()->store_id)->delete();
               ProductImage::where('product_id',$id)->where('store_id',auth()->user()->store_id)->delete();
               ProductPairing::where('product_id',$id)->where('store_id',auth()->user()->store_id)->delete();
               ProductSpecial::where('product_id',$id)->where('store_id',auth()->user()->store_id)->delete();
               ProductPromo::where('product_id',$id)->where('store_id',auth()->user()->store_id)->delete();
               $prod->delete();
           DB::commit();

           return redirect()->route('product')->with('message','Produk Berhasil dihapus');
       }
        return redirect()->route('product')->with('error','Produk tidak bisa dihapus karena sudah terjual');
    }
}
