<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use App\Models\UserOauthAccount;
 
class User extends Model
{
    use HasFactory;

    const REGISTRATION_TYPE_TRADITIONAL = 0;
    const REGISTRATION_TYPE_OAUTH = 1;

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'cpf',
        'registration_method',
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

    public function UserOauthAccount() {
        return $this->hasOne(UserOauthAccount::class);
    }
}
