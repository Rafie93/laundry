<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Master\BarangList as ListResource;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;
use App\Models\Outlets\Items;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Items::orderBy('id','desc')
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
        Items::create($request->all());
        return response()->json(['success'=>true,'message'=>'Item Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $items = Items::find($id);
        $items->update($request->all());
        return response()->json(['success'=>true,'message'=>'Item Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request)
    {
        $items = Items::find($id);
        $items->delete();
        return response()->json(['success'=>true,'message'=>'Items Berhasil dihapus'], 200);

    }
}
