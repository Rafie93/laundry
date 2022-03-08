<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    use HasFactory;
    protected $table = "point_history";
    protected $fillable = [
        'user_id',
        'description',
        'qty',
        'actual'
    ];
}