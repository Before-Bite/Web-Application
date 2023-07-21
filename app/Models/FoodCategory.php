<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;
    protected $table = 'food_categories';
    protected $fillable = [
        'food_category_name',
        'images',
    ];

    public function Foods()
    {
        return $this->hasMany(Foods::class,'category_id','id');
    }
}
