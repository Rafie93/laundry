<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Users\UserManajemen;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'fcm_token',
        'level',
        'birthday',
        'phone',
        'status',
        'gender',
        'point',
        'role'
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

    function isSuperAdmin()
    {
        return $this->role == 1;
    }
    function isOwner()
    {
        return $this->role == 2;
    }

    public function outlet_id()
    {
        $userId = $this->id;
        $manajemen = UserManajemen::orderBy('id','desc')
                        ->where('user_id',$userId)->where('status',1)
                        ->first();
    
        if ($manajemen) {
            return $manajemen->outlet_id;
        }else{
            return null;
        }

    }

    function IN_STORE()
    {
        $store = array(2,3,4);

        if(in_array($this->role,$store)){
            return true;
        }
        return false;
    }
    public function IS_ROLE()
    {
        $role = "";
        switch ($this->role) {
            case 1:
                $role ="SUPER ADMIN";
                break;
            case 2:
                $role ="OWNER OUTLET";
                break;
            case 3:
                $role ="ADMIN OUTLET";
                break;
            case 4:
                $role ="KASIR OUTLET";
                break;
            case 5:
                    $role ="CUSTOMER";
                    break;
            default:
                $role = "";
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
   
    
    public function IS_CMS_LOGIN()
    {
        $login = array(2,3);
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
