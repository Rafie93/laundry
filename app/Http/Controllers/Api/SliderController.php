<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information\Slider;
use App\Http\Resources\Slider\SliderList as ListResource;

class SliderController extends Controller
{
    public function index(Request $request)
    {
       $slider = Slider::orderBy('id','desc')
                    ->whereNull('store_id')
                    ->paginate(8);

       return new ListResource($slider);
    }

     public function store(Request $request,$id)
    {
       $slider = Slider::orderBy('id','desc')
                    ->where('store_id',$id)
                    ->paginate(10);

       return new ListResource($slider);
    }
}
