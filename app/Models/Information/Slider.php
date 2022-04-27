<?php

namespace App\Models\Information;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = "banners";
    protected $fillable = ["title","file","link","description"];

    public function file()
    {
        return $this->file==null ? 'Tidak Ada Image' : asset('images/slider/'.$this->file);
    }

}
