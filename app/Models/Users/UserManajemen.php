<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManajemen extends Model
{
    use HasFactory;
    protected $table = "user_manajemen";
    protected $fillable = [
        'user_id',
        'role',
        'outlet_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
