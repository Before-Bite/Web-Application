<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurent extends Model
{
    use HasFactory;
    protected $table = 'restaurent';
    protected $fillable = [
        'place_id',
        'user_id',
        'restaurant_name',
        'food_category',
        'food_item',
        'rating',
        'review',
        'dish_name',
        'dish_picture',
        'lat',
        'long',
        'width',
        'height',
        'photo_reference'
    ];

    public function Comments()
    {
        return $this->hasMany(Commants::class,'post_id','id');
    }

    public function Users()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function UsersProfile()
    {
        return $this->hasOne(ProfileSetup::class,'user_id','user_id');
    }

    public function Likes()
    {
        return $this->hasOne(LikePost::class,'post_id','id')->selectRaw('post_id, count(*) as count')->groupBy('post_id');
    }
}
