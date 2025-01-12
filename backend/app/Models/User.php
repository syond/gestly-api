<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Model;
 
class User extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'cpf',
    ];

    // Guarantee the conversion to correctly data type for each field
    protected $casts = [
        'birth_date' => 'datetime',
    ];

    function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * Define the relationship between User and PostInteraction
     * In this case we have a many-to-many relationship between User and Post
     * It's not affecting the others relationships
     */
    function postInteraction() {
        return $this->belongsToMany(Post::class, 'post_interactions')
            ->withPivot('interaction_type')
            ->withTimestamps();
    }
}
