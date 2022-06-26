<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MethodPayment;
use App\Http\Resources\Master\MethodList as ListResource;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;

class MethodPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = MethodPayment::orderBy('id','asc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

        if ($data->count() == 0) {
           $default =  MethodPayment::orderBy('id','asc')->whereNull('outlet_id')->get();
           foreach ($default as $row) {
            MethodPayment::create([
                'outlet_id' => $user->outlet_id,
                'name'=> $row->name,
                'type' => $row->type,
                'logo'=>$row->logo
              ]);
           }
           $data = MethodPayment::orderBy('id','asc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();
        }

        return new ListResource($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'logo' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();                            
           $request->merge(['outlet_id'=>$user->outlet_id]);
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
        return response()->json(['success'=>true,'message'=>'Metode Pembayaran Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
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
        return response()->json(['success'=>true,'message'=>'Metode Pembayaran Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request,$id)
    {
        $method = MethodPayment::find($id);
        $method->delete();
        return response()->json(['success'=>true,'message'=>'Metode Pembayaran Berhasil dihapus'], 200);

    }
}
