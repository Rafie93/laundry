<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Satuan;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $satuans = Satuan::orderBy('id','desc')
                            ->where(function ($query) {
                                if (auth()->user()->isSuperAdmin() ){
                                    $query->whereNull('outlet_id');
                                }else{
                                    $query->where('outlet_id','=', auth()->user()->outlet_id());
                                }
                            })                        
                            ->paginate(10);
        
        return view('satuans.index',compact('satuans'));
    }

    public function create(Request $request)
    {
       return view('satuans.create');
    }
    public function edit(Request $request,$id)
    {
       $data = Satuan::find($id); 
       return view('satuans.edit',compact('data'));
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
    
        Satuan::create($request->all());
        return redirect()->route('satuan')->with('message','Satuan Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'name' => 'required',
        ]);
        $satuan = Satuan::find($id);
        $satuan->update($request->all());
        return redirect()->route('satuan')->with('message','Satuan Baru Berhasil diperbaharui');
    }
    public function delete($id)
    {
        $cat = Satuan::find($id);
        $cat->delete();
        return redirect()->route('satuan')->with('message','Satuan Berhasil dihapus');
       
    }
}
