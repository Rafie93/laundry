<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTable extends Model
{
    use HasFactory;
    protected $table = "store_table";
    protected $fillable = [
        'store_id',
        'table_number',
        'description',
        'sequence',
        'minimum_shopping',
        'maximum',
        'is_ready',
        'status',
        'image',
    ];
    public function store()
    {
        return $this->belongsTo('App\Models\Stores\Store','store_id');
    }

    public function DisplayReady()
    {
        if ($this->is_ready==1) {
           return '<span class="badge badge-pill badge-success">Tersedia</span>';
        }else{
            return '<span class="badge badge-pill badge-danger">Tidak Tersedia</span>';
        }
    }

    public function image()
    {
        return $this->image==null ? 'Tidak Ada Image' : asset('images/seat/'.$this->image);
    }
}