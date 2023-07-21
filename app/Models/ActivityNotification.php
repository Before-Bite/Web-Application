<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityNotification extends Model
{
    use HasFactory;

    protected $table = 'activity_notification';
    protected $fillable = [
        'user_id',
        'post_id',
        'follow',
        'status',
        'friend_id'
    ];

    public function Users()
    {
        return $this->hasOne(User::class,'id','user_id');
    } 

    public function UserProfile()
    {
        return $this->hasOne(ProfileSetup::class,'user_id','user_id');
    } 
}
