<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Follow extends Model
{
    use HasFactory;
    protected $table = 'follow';
    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
    ];
    
    
    public function followers()
    {
        return $this->hasManyThrough(
            User::class,

            'User_id' // Foreign key on posts table...
            
        );
    }
}
