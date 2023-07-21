<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;
    protected $table = 'food';
    protected $fillable = [
        'category_id',
        'food_name',
    ];

    public function FoodCategory()
    {
        return $this->belongsTo(FoodCategory::class,'category_id','id');
    }
}
