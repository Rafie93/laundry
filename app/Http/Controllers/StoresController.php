<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Outlets\Outlet;
use App\Models\Outlets\Merchant;

class StoresController extends Controller
{
    
    public function index()
    {
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();

        $stores = Outlet::orderBy('merchant_id','asc')
                        ->where(function ($query) use ($owner) {
                            if (auth()->user()->role==2 ){
                                $query->where('merchant_id',$owner->id);
                            }
                        })
                        ->paginate(10);
        return view('stores.index', compact('stores'));
    }
    
    public function create()
    {
       return view('stores.create');
    }
     public function edit($id)
    {
        $data = Outlet::find($id);
       return view('stores.edit',compact('data'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:2',
            'address'    => 'required',
            'phone'=>'required',
        ]);
        $store = Outlet::create($request->all());
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/stores/',$fileName);
            $store->logo= $fileName;
            $store->save();
       }
        return redirect()->route('stores')->with('message','Toko Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
          $this->validate($request,[
            'name' => 'required|min:2',
            'address'    => 'required',
            'phone'=>'required',
        ]);
        $store = Outlet::find($id);
        $store->update($request->all());
        if ($request->hasFile('file')) {
            $image_path = public_path().'/images/stores/'.$store->logo;
            unlink($image_path);

            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/stores/',$fileName);
            $store->update(['logo'=>$fileName]);
       }
        return redirect()->route('stores')->with('message','Toko Baru Berhasil diperbaharui');
    }
}
