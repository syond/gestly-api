<?php

namespace App\Models;

use App\Models\Model;

class MediaObject extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'file_extension',
    ];    
}
