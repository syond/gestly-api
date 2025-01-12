<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'email' => $this->faker->email(),
            'birth_date' => $this->faker->date('Y-m-d\TH:i:s.v\Z'),
            'cpf' => $this->faker->numerify('###########'),
        ];
    }
}
