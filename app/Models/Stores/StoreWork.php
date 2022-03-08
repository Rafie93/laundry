<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreWork extends Model
{
    use HasFactory;
    protected $table = "store_work";
    protected $fillable = ["store_id","day","open_time","close_time"];
}
