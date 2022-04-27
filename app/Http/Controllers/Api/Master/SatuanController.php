<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Satuan;
use App\Http\Resources\Master\SatuanList as ListResource;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Satuan::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

        if ($data->count() == 0) {
           $default =  Satuan::orderBy('id','desc')->whereNull('outlet_id')->get();
           foreach ($default as $row) {
              Satuan::create([
                'outlet_id' => $user->outlet_id,
                'name'=> $row->name,
                'alias' => $row->alias
              ]);
           }
           $data = Satuan::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();
        }

        return new ListResource($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'alias' => 'required'
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
        Satuan::create($request->all());
        return response()->json(['success'=>true,'message'=>'Satuan Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'alias' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $satuans = Satuan::find($id);
        $satuans->update($request->all());
        return response()->json(['success'=>true,'message'=>'Satuan Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request)
    {
        $satuans = Satuan::find($id);
        $satuans->delete();
        return response()->json(['success'=>true,'message'=>'Satuan Berhasil dihapus'], 200);

    }
}
