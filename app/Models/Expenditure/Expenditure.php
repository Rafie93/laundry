<?php

namespace App\Models\Expenditure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;
    protected $table = "expenditure";
    protected $fillable = ["outlet_id","expenditure_category_id","name","date","cost","note","creator_id","status"];

    public function category()
    {
        return $this->belongsTo('App\Models\Expenditure\ExpenditureCategory','expenditure_category_id');
    }
}
