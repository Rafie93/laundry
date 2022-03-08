<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $table = "taxs";
    protected $fillable = [
        "store_id",
        "code",
        "name",
        "type",
        "amount",
        "status"
    ];
}
