<?php

namespace Database\Factories;

use App\Models\FormInput;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormInputFactory extends Factory
{
    protected $model = FormInput::class;

    public function definition()
    {
        $inputHtmlExample = [
            'id' => 'first_name',
            'label' => 'First Name',
            'type' => 'text',
            'maxlength' => 15,
            'required' => true,
        ];

        return [
            'content' => json_encode($inputHtmlExample),
        ];
    }
}
