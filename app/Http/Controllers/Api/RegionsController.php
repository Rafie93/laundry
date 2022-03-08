<?php

namespace App\Http\Controllers\Api;

use App\Models\Regions\City;
use App\Models\Regions\District;
use App\Models\Regions\RegionQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    private $queryObject;

    public function __construct(RegionQuery $queryObject)
    {
        $this->queryObject = $queryObject;
    }

    public function provinces()
    {
        return $this->queryObject->getProvincesList();
    }

    public function cities(Request $request)
    {
        if ($provinceId = $request->get('province_id'))
            return $this->queryObject->getCitiesList($provinceId);

        return $this->queryObject->getCitiesList();
    }

    public function city(Request $request)
    {
        $data = City::select('id','name')->get();
        if ($provinceId = $request->get('province_id'))
            $data = City::select('id','name')->where('province_id',$provinceId)->get();

        return response()->json($data,200);
    }

    public function districts(Request $request)
    {
        if ($cityId = $request->get('city_id'))
            $data = District::select('id','name')->where('city_id',$cityId)->get();
            return response()->json($data,200);


        return [];
    }
}
