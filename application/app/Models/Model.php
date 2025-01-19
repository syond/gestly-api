<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel {
    protected $hidden = [
        'pivot' // pivot attr returned on many-to-many relationship
    ];
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d\TH:i:s.v\Z');
    }
}