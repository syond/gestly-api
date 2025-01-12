<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'adress',
        'user_id',
        'category_id',
    ];

    function user() {
        return $this->belongsTo(User::class);
    }

    function category() {
        return $this->belongsTo(Category::class);
    }

    function userIntereactions() {
        return $this->belongsToMany(User::class, 'post_interactions')
            ->withPivot('interaction_type')
            ->withTimestamps();
    }
}
