<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categorys = Category::orderBy('id','desc')
                        ->where('deleted',0)
                        ->where(function ($query) {
                            if (auth()->user()->isSuperAdmin() ){
                                $query->whereNull('outlet_id');
                            }else{
                                $query->where('outlet_id','=', auth()->user()->outlet_id());
                            }
                        })->paginate(10);


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

        if (!auth()->user()->isSuperAdmin() ){
           $request->merge([
            'outlet_id' => auth()->user()->outlet_id(),
           ]);
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
       if ($cat->service->count() == 0) {
           $cat->delete();
           return redirect()->route('category')->with('message','Kategori Berhasil dihapus');
       }else{
        $cat->update([
            'deleted' => 1
        ]);
        return redirect()->route('category')->with('message','Kategori Berhasil dihapus');

       }
    }
}
