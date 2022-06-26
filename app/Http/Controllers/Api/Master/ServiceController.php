<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Service;
Use App\Models\Users\UserManajemen;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Category;
use App\Http\Resources\Master\ServiceList as ListResource;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();
                                        
        $data = Service::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();

        if ($data->count() == 0) {
           $default =  Service::orderBy('id','desc')->whereNull('outlet_id')->get();
           foreach ($default as $row) {
            Service::create([
                'outlet_id' => $user->outlet_id,
                'name'=> $row->name,
                'satuan' => $row->satuan,
                'category_id' => $row->category_id,
                'price'=> $row->price,
                'estimasi'=> $row->estimasi,
                'estimasi_type'=> $row->estimasi_type,
                'icon'=>$row->icon
              ]);
           }
           $data = Service::orderBy('id','desc')
                        ->where('outlet_id',$user->outlet_id)
                        ->get();
        }

        return new ListResource($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'estimasi' => 'required',
            'satuan' => 'required',
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
        Service::create($request->all());
        return response()->json(['success'=>true,'message'=>'Layanan Berhasil disimpan'], 200);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'estimasi' => 'required',
            'satuan' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array("errors"=>validationErrors($validator->errors())), 422);
        }
       
        $service = Service::find($id);
        $service->update($request->all());
        return response()->json(['success'=>true,'message'=>'Layanan Berhasil diperbaharui'], 200);
    }

    public function delete(Request $request,$id)
    {
        $service = Service::find($id);
        $service->update([
            'deleted'=>1
        ]);
        return response()->json(['success'=>true,'message'=>'Layanan Berhasil dihapus'], 200);

    }
}
