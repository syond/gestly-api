<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'birth_date',
    ];

    // Garantee the conversion to correctly data type for each field
    protected $casts = [
        'birth_date' => 'datetime',
    ];
}
