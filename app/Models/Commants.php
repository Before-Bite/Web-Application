<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commants extends Model
{
    use HasFactory;
    protected $table = 'commants';
    protected $fillable = [
        'user_id',
        'post_id',
        'comments'
    ];

    public function UsersProfile()
    {
        return $this->hasOne(ProfileSetup::class,'user_id','user_id');
    }

    public function User()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
