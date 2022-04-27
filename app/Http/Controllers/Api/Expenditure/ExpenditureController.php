<?php

namespace App\Http\Controllers\Api\Expenditure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenditure\Expenditure;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Expenditure\ExpenditureList as ListResource;

class ExpenditureController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Expenditure::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

        return new ListResource($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'expenditure_category_id' => 'required',
            'cost' => 'required|numeric',
            'date' => 'required|date|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $request->merge(['creator_id'=>auth()->user()->id]);
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();                            
           $request->merge(['outlet_id'=>$user->outlet_id]);
        }
        Expenditure::create($request->all());
        return response()->json(['success'=>true,'message'=>'Pengeluaran Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'expenditure_category_id' => 'required',
            'cost' => 'required|numeric',
            'date' => 'required|date|date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
        $request->merge(['creator_id'=>auth()->user()->id]);
        $pengeluaran = Expenditure::find($id);
        $pengeluaran->update($request->all());
        return response()->json(['success'=>true,'message'=>'Pengeluaran Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request)
    {
        $items = Expenditure::find($id);
        $items->delete();
        return response()->json(['success'=>true,'message'=>'Pengeluaran Berhasil dihapus'], 200);
    }
}
