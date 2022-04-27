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
                    ->get();

       return new ListResource($slider);
    }

}
