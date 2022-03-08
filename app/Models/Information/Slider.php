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
        return $this->slide==null ? 'Tidak Ada Image' : asset('images/banner/'.$this->file);
    }

}
