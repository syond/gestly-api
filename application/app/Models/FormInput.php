<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    public function form()
    {
        return $this->belongsToMany(Form::class, 'form_input_form', 'form_input_id', 'form_id');
    }
}
