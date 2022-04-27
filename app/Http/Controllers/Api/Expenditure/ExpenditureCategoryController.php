<?php

namespace App\Http\Controllers\Api\Expenditure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenditure\ExpenditureCategory;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;

class ExpenditureCategoryController extends Controller
{
    public function index()
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();

        $categories = ExpenditureCategory::where('outlet_id',$user->outlet_id)
                            ->where('status',1)
                            ->get();
        $output = array();
        foreach ($categories as $row) {
            $output[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'status' => $row->status,
            );
        }
        return response()->json(['success'=>true,'data'=>$output], 200);
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
        ExpenditureCategory::create($request->all());
        return response()->json(['success'=>true,'message'=>'Kategori Pengeluaran Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $items = ExpenditureCategory::find($id);
        $items->update($request->all());
        return response()->json(['success'=>true,'message'=>'Kategori Pengeluaran Berhasil diperbaharui'], 200);
    }
    public function delete(Request $request)
    {
        $items = ExpenditureCategory::find($id);
        $items->update([
            'status' => 0
        ]);
        return response()->json(['success'=>true,'message'=>'Kategori Pengeluaran Berhasil dihapus'], 200);

    }
}
