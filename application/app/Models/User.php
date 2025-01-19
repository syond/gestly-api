<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
 
class User extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'cpf',
    ];

    // Guarantee correctly data type conversion for each field
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
