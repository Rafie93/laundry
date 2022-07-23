<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    protected $table = "merchant";
    protected $fillable = ["name","phone","owner_id","package_member_id","expired","status"];
    public function package()
    {
        return $this->belongsTo('App\Models\Sistem\PackageMember','package_member_id');
    }

    public function outlet()
    {
        return $this->hasMany('App\Models\Outlets\Outlet', 'merchant_id');
    }

    public function isStatusDisplay()
    {
        $awal  = date_create($this->expired);
        $akhir = date_create(); 
        $diff  = date_diff( $awal, $akhir );
        if ($akhir > $awal) {
            return "Expired";
        }
        return "Aktif";
    }
}
