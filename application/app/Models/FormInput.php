<?php

namespace App\Models;

use App\Models\Model;

class FormInput extends Model
{
    protected $fillable = [
        'content',
    ];

    public function form()
    {
        return $this->belongsToMany(Form::class, 'form_input_form', 'form_input_id', 'form_id');
    }
}
