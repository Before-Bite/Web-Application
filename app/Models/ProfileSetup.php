<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSetup extends Model
{
    use HasFactory;
    protected $table = 'profile_setup';
    protected $fillable = [
        'user_id',
        'lat',
        'long',
        'first_name',
        'last_name',
        'gender',
        'clain_for_fame',
        'image'
    ];

    public function ProfileSetup1()
    {
        return $this->belongsTo(User::class,'id','User_id');
    }
}
