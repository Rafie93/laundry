<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesEvent extends Model
{
    use HasFactory;
    protected $table = "sales_event";
    protected $fillable = ["sale_id","event_id","qty","remainder","status","member_id"];


    public function event()
    {
        return $this->belongsTo("App\Models\Events\Event","event_id");
    }
}
