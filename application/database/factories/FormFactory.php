<?php

namespace Database\Factories;

use App\Models\Form;
use App\Models\FormInput;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    protected $model = Form::class;

    public function definition() {
        return [
            'title' => $this->faker->sentence(3),
            'is_default' => $this->faker->boolean(0),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Form $form) {
            $formInputs = FormInput::factory(3)->create();
            $form->formInputs()->attach($formInputs);
        });
    }
}
