<?php

namespace App\Models\Regions;

use App\Models\Regions\City;
use App\Models\Regions\District;
use App\Models\Regions\State;
/**
* Region Query Object
*/
class RegionQuery
{
    public function getProvincesList()
    {
        return State::select('name','id')->get();
    }

    public function getCitiesList($provinceId = null)
    {
        if (!$provinceId)
            return City::pluck('name','id');


        return City::whereProvinceId($provinceId)->pluck('name','id');
    }

    public function getCities($provinceId = null)
    {
        if (!$provinceId)
            return City::select('name','id')->get();

        return City::whereProvinceId($provinceId)->select('name','id')->get();
    }

    public function getDistrictsList($cityId = null)
    {
        if (!$cityId)
            return [];

        return District::whereCityId($cityId)->pluck('name','id');
    }

}
