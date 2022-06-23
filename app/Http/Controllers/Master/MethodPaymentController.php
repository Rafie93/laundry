<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MethodPayment;
Use App\Models\Users\UserManajemen;

class MethodPaymentController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                ->where('status',1)
                                ->first();
            
            $data = MethodPayment::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

            if ($data->count() == 0) {
                $default =  MethodPayment::orderBy('id','asc')->whereNull('outlet_id')->get();
                foreach ($default as $row) {
                    MethodPayment::create([
                        'outlet_id' => $user->outlet_id,
                        'name'=> $row->name,
                        'type' => $row->type,
                        'logo' => $row->logo
                    ]);
                 } 
            }
        }

        $methods = MethodPayment::orderBy('id','asc')
                            ->where(function ($query) {
                                if (auth()->user()->isSuperAdmin() ){
                                    $query->whereNull('outlet_id');
                                }else{
                                    $query->where('outlet_id','=', auth()->user()->outlet_id());
                                }
                            })                        
                            ->paginate(10);
        
        return view('methods.index',compact('methods'));
    }

    public function create(Request $request)
    {
       return view('methods.create');
    }
    public function edit(Request $request,$id)
    {
       $data = MethodPayment::find($id); 
       return view('methods.edit',compact('data'));
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'name' => 'required|unique:method_payment',
            'type' => 'required',
            'logo' => 'required'
        ]);

        if (!auth()->user()->isSuperAdmin() ){
            $request->merge([
             'outlet_id' => auth()->user()->outlet_id(),
            ]);
         }
    
        $method = MethodPayment::create($request->all());
         if ($request->hasFile('logo')) {
            $originName = $request->file('logo')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileName = date('ymd').'_'.time().'.'.$extension;
            $request->file('logo')->move('images/method/',$fileName);
            $method->logo = $fileName;
            $method->save();
        }
        return redirect()->route('method')->with('message','method Baru Berhasil ditambahkan');
    }
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'name' => 'required',
            'type' => 'required',
        ]);
        $method = MethodPayment::find($id);
        $method->update($request->all());
        if ($request->hasFile('logo_change')) {
            $originName = $request->file('logo_change')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('logo_change')->getClientOriginalExtension();
            $fileName = date('ymd').'_'.time().'.'.$extension;
            $request->file('logo_change')->move('images/method/',$fileName);
            $method->logo = $fileName;
            $method->save();
        }
        return redirect()->route('method')->with('message','method Baru Berhasil diperbaharui');
    }
    public function delete($id)
    {
        $cat = MethodPayment::find($id);
        $cat->delete();
        return redirect()->route('method')->with('message','method Berhasil dihapus');

    }
}
