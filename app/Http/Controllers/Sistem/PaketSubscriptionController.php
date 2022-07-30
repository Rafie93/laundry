<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sistem\PackageMember;
use App\Models\Outlets\Merchant;
class PaketSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $pakets = PackageMember::orderBy('id','desc')
                        ->whereNull('deleted_at')
                        ->paginate(10);


        return view('paket.index',compact('pakets'));
    }

    public function create(Request $request)
    {
       return view('paket.create');
    }
    public function edit(Request $request,$id)
    {
       $data = PackageMember::find($id); 
       return view('paket.edit',compact('data'));
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'package' => 'required',
            'price' => 'required',
            'duration'=>'required',
            'duration_day'=>'required',
        ]);

        $request->merge([
            'status' => 1,
        ]);
    
        PackageMember::create($request->all());
        return redirect()->route('paket')->with('message','Paket Berlangganan Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'package' => 'required',
            'price' => 'required',
            'duration'=>'required',
            'duration_day'=>'required',

        ]);
        $paket = PackageMember::find($id);
        $paket->update($request->all());
        return redirect()->route('paket')->with('message','Paket Berlangganan Baru Berhasil diperbaharui');
    }
    public function delete($id)
    {
       $cat = PackageMember::find($id);
       $m = Merchant::where('package_member_id',$id)->get()->count();
       if ($m > 0) {
            $cat->update([
                'status' => 0,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('paket')->with('message','Status Paket Berlangganan Di Non Aktifkan');
       }else{
            $cat->delete();
            return redirect()->route('paket')->with('message','Paket Berlangganan Berhasil dihapus');
       } 
     
    }
}
