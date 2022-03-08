<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
         $categorys = Category::orderBy('id','desc')->whereNull('outlet_id')->paginate(20);
            $categorys = Category::orderBy('id','desc')
                        ->where('outlet_id',auth()->user()->outlet_id)
                        ->paginate(10);
        

        return view('categorys.index',compact('categorys'));
    }

    public function create(Request $request)
    {
       return view('categorys.create');
    }
    public function edit(Request $request,$id)
    {
       $data = Category::find($id); 
       return view('categorys.edit',compact('data'));
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'name' => 'required',
        ]);
        if (auth()->user()->IN_STORE()) {
            $request->merge(['store_id'=>auth()->user()->store_id]);
        }

        Category::create($request->all());
        return redirect()->route('category')->with('message','Kategori Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'name' => 'required',
        ]);
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('category')->with('message','Kategori Baru Berhasil diperbaharui');
    }
    public function delete($id)
    {
       $cat = Category::find($id);
       if ($cat->products->count() == 0) {
           $cat->delete();
           return redirect()->route('category')->with('message','Kategori Berhasil dihapus');
       }
        return redirect()->route('category')->with('error','Kategori tidak bisa dihapus');
    }
}
