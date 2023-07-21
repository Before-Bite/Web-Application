<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $table = 'storys';
    protected $fillable = [
        'user_id',
        'contentType',
        'content',
    ];
    public function Users()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
