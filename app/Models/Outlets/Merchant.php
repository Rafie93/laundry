<?php

namespace App\Models\Outlets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    protected $table = "merchant";
    protected $fillable = ["name","phone","owner_id","package_member_id","expired","status"];
}
