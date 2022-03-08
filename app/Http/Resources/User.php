<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    public function toArray($request)
    {
        $user = $this->resource;
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
            'fcm_token' => $user->fcm_token ? $user->fcm_token : ''
        ];
        return $userData;
    }

    public function with($request)
    {
        if ($request->route()->getName() == 'api.login.mail' || $request->route()->getName() == 'api.login.otp') {
            return ['success' => true, 'token' => $this->resource->createToken('nApp')->accessToken];
        }
        return [];
    }
}
