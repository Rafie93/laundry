<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Master\ParfumeList as ListResource;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;
use App\Models\Outlets\Parfume;

class ParfumeController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Parfume::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

        return new ListResource($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
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
        Parfume::create($request->all());
        return response()->json(['success'=>true,'message'=>'Parfume Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $parfume = Parfume::find($id);
        $parfume->update($request->all());
        return response()->json(['success'=>true,'message'=>'Parfume Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request)
    {
        $parfume = Parfume::find($id);
        $parfume->delete();
        return response()->json(['success'=>true,'message'=>'Parfume Berhasil dihapus'], 200);

    }
}
