<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Service;
use App\Models\Master\Category;
use App\Models\Master\Satuan;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $layanans = Service::orderBy('id','desc')
                            ->where(function ($query) {
                                if (auth()->user()->isSuperAdmin() ){
                                    $query->whereNull('outlet_id');
                                }else{
                                    $query->where('outlet_id','=', auth()->user()->outlet_id());
                                }
                            })                    
                            ->paginate(10);
    

        return view('layanan.index',compact('layanans'));
    }

    public function create(Request $request)
    {
        $categories  = Category::orderBy('id','desc')
                                ->where(function ($query) {
                                    if (auth()->user()->isSuperAdmin() ){
                                        $query->whereNull('outlet_id');
                                    }else{
                                        $query->where('outlet_id','=', auth()->user()->outlet_id());
                                    }
                                })->get();

        $satuans = Satuan::orderBy('id','desc')
                                ->where(function ($query) {
                                    if (auth()->user()->isSuperAdmin() ){
                                        $query->whereNull('outlet_id');
                                    }else{
                                        $query->where('outlet_id','=', auth()->user()->outlet_id());
                                    }
                                })                        
                                ->get();

       return view('layanan.create',compact('categories','satuans'));
    }
    public function edit(Request $request,$id)
    {
        $categories  = Category::orderBy('id','desc')
                                ->where('outlet_id',auth()->user()->outlet_id())
                                ->where(function ($query) {
                                    if (auth()->user()->isSuperAdmin() ){
                                        $query->whereNull('outlet_id');
                                    }else{
                                        $query->where('outlet_id','=', auth()->user()->outlet_id());
                                    }
                                })->get();

        $satuans = Satuan::orderBy('id','desc')
                                ->where(function ($query) {
                                    if (auth()->user()->isSuperAdmin() ){
                                        $query->whereNull('outlet_id');
                                    }else{
                                        $query->where('outlet_id','=', auth()->user()->outlet_id());
                                    }
                                })                        
                                ->get();

       $data = Service::find($id); 
       return view('layanan.edit',compact('data','categories','satuans'));
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ]);
        if (!auth()->user()->isSuperAdmin() ){
            $request->merge([
             'outlet_id' => auth()->user()->outlet_id(),
            ]);
         }
     
        Service::create($request->all());
        return redirect()->route('layanan')->with('message','Layanan Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'name' => 'required',
        ]);
        $layanan = Service::find($id);
        $layanan->update($request->all());
        return redirect()->route('layanan')->with('message','Layanan Baru Berhasil diperbaharui');
    }
    public function delete($id)
    {
       $cat = Service::find($id);
       if ($cat->service->count() == 0) {
           $cat->delete();
           return redirect()->route('layanan')->with('message','Layanan Berhasil dihapus');
       }
        return redirect()->route('layanan')->with('error','Layanan tidak bisa dihapus');
    }
}
