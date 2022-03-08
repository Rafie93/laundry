<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'fullname',
        'email',
        'password',
        'fcm_token',
        'level',
        'birthday',
        'phone',
        'status',
        'gender',
        'point'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function IN_STORE()
    {
        $store = array(12,13,14,16);

        if(in_array($this->role,$store)){
            return true;
        }
        return false;
    }
    public function IS_ROLE()
    {
        $role = "CUSTOMER";
        switch ($this->role) {
            case 11:
                $role ="SUPER ADMIN";
                break;
            case 12:
                $role ="ADMIN STORE";
                break;
            case 13:
                $role ="CS STORE";
                break;
            case 14:
                $role ="KASIR";
                break;
            case 16:
                $role ="KURIR";
                break;
            default:
                $role = "CUSTOMER";
                break;
        }

        return $role;
    }
    public function IS_STATUS()
    {
        if ($this->status==1) {
           return "Aktif";
        }else  if ($this->status==2) {
           return "Dihapus";
        }else{
            return "Tidak Aktif";
        }
    }
    public function IS_GENDER()
    {
        if ($this->gender=="LK") {
           return "Laki-Laki";
        }else{
            return "Perempuan";
        }
    }
    
    public function IS_CMS_LOGIN()
    {
        $login = array(11,12,13,14,16);
        if(in_array($this->role,$login)){
            return true;
        }
        return false;
    }

    public function isExpiredOtp()
    {
        $expiredTime = $this->otp_expired;
        if ($expiredTime!=null) {
           if (date('Y-m-d H:i:s') <= $expiredTime) {
              return  true;
           }else{
               return false;
           }
        }else{
            return false;
        }
    }


    public function stores()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }
}
