<?php

namespace App\Models\Expenditure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureCategory extends Model
{
    use HasFactory;
    protected $table = "expenditure_category";
    protected $fillable = ["outlet_id","name","status"];
}
