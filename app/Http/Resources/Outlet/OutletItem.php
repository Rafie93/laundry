<?php

namespace App\Http\Resources\Outlet;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
Use App\Models\Users\UserManajemen;

class OutletItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $awal  = date_create($this->resource->merchant->expired);
        $akhir = date_create(); // waktu sekarang
        $diff  = date_diff( $awal, $akhir );
        if ($akhir > $awal) {
           $hari = "0 Hari";
           $status = "Expired";
        }else{
            $hari = $diff->days." Hari";
            $status = "Aktif";
        }

        $manaj = UserManajemen::where('user_id',auth()->user()->id)
                        ->where('status',1)
                        ->first();

        $is_switch = true;
        if ($manaj) {
            $manaj_id = $manaj_id->outlet_id;
            if ($manaj_id == $this->resource->id) {
               $is_switch = false;
            }
        }

        return  [
            'id'      => intval($this->resource->id),
            'merchant_id' => intval($this->resource->merchant_id),
            'code' => $this->resource->code,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'email' => $this->resource->email,
            'city_id' => strval($this->resource->city_id),
            'district_id' => strval($this->resource->district_id),
            'address' => $this->resource->address,
            'logo' => $this->resource->logo,
            'expired' => $hari,
            'status' => $status,
            'is_switch' => $is_switch,
        ]; 
    }
}
