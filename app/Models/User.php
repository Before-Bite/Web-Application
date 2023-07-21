<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'access_token',
        'isSocialLogin',
    ];

    public function ProfileSetup()
    {
        return $this->hasOne(ProfileSetup::class,'user_id','id');
    }

    public function UserLanguages()
    {
        return $this->hasMany(UserLanguages::class,'user_id','id');
    }
    public function Post()
    {
        return $this->hasMany(Restaurent::class,'user_id','id');
    }

    public function Following()
    {
        return $this->hasone(Follow::class,'user_id','id')->selectRaw('user_id, count(*) as count')->groupBy('user_id');
    }

    public function Follow()
    {
        return $this->hasone(Follow::class,'friend_id','id')->selectRaw('friend_id, count(*) as count')->groupBy('friend_id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
