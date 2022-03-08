<?php

namespace App\Models\Information;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = "news";
    protected $fillable = ["title","tag","description","status","createdAt","slug","cover"];
    
    public function cover()
    {
        return $this->cover==null ? 'Tidak Ada Image' : asset('images/news/'.$this->cover);
    }

}
