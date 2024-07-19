<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'thumbnail',
        'user_id',
        'slug',
        'content'
    ];

    public function product_user(): HasOne{
        return $this->hasOne(User::class,'user_id');
    }

    public function Tag(){
        return $this->hasMany(Tag_Post::class);
    }
}
