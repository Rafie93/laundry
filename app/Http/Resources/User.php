<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
Use App\Models\Outlets\Outlet;
Use App\Models\Users\UserManajemen;

class User extends JsonResource
{
    public function toArray($request)
    {
        $user = $this->resource;
        $userManajemen = UserManajemen::where('user_id',$user->id)
                                ->where('status',1)
                                ->first();
        $outlet = Outlet::where('id',$userManajemen->outlet_id)->first();

        $awal  = date_create($outlet->merchant->expired);
        $akhir = date_create(); 
        $diff  = date_diff( $awal, $akhir );
        if ($akhir > $awal) {
            $hari = "0 Hari";
            $status = "Expired";
        }else{
            $hari = $diff->days." Hari";
            $status = "Aktif";
        }
        $userData = [
            'id'        => $user->id,
            'fullname'      => $user->fullname ? $user->fullname : '',
            'birthday' => $user->birthday,
            'email'     => $user->email ?  $user->email :'',
            'phone'     => $user->phone,
            'gender' => $user->gender ? $user->gender : '',
            'point'=>  $user->point ? $user->point : 0,
            'level'=>$user->level ? $user->level : 'regular',
            'image'  => '',
            'role_id'  => $user->role,
            'role_display'  => $user->IS_ROLE(),
            'fcm_token' => $user->fcm_token ? $user->fcm_token : '',
            'hari' => $hari,
            'outlet_id' => $userManajemen->outlet_id,
            'status_outlet' => $status,
        ];
        return $userData;
    }

    public function with($request)
    {
        if ($request->route()->getName() == 'api.login' || $request->route()->getName() == 'api.login') {
            return ['success' => true, 'token' => $this->resource->createToken('nApp')->accessToken];
        }
        return [];
    }
}
