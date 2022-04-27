<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Category;
use App\Http\Resources\Master\CategoryList as ListResource;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                    ->where('status',1)
                    ->first();
                    
        $data = Category::orderBy('id','desc')
                    ->where('deleted',0)
                    ->where('outlet_id',$user->outlet_id)
                    ->get();

        if ($data->count() == 0) {
            $default =  Category::orderBy('id','desc')->whereNull('outlet_id')->where('deleted',0)->get();
            foreach ($default as $row) {
                Category::create([
                'outlet_id' => $user->outlet_id,
                'name'=> $row->name,
                ]);
            }
            $data = Category::orderBy('id','desc')
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
        Category::create($request->all());
        return response()->json(['success'=>true,'message'=>'Kategori Berhasil disimpan'], 200);
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
       
        $category = Category::find($id);
        $category->update($request->all());
        return response()->json(['success'=>true,'message'=>'Kategori Berhasil diperbaharui'], 200);
    }

    public function delete(Request $request)
    {
        $category = Category::find($id);
        $category->update([
            'deleted'=>1
        ]);
        return response()->json(['success'=>true,'message'=>'Kategori Berhasil dihapus'], 200);

    }
}
