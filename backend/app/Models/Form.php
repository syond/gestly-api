<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title',
        'is_default',
    ];

    public function formInputs()
    {
        return $this->belongsToMany(FormInput::class, 'form_input_forms', 'form_id', 'form_input_id');
    }
}
