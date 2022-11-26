<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PreguntaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'enunciado'=> $this->faker->words(7, true),
			'tipo'=> $this->faker->randomElement(['A', 'O']),
			'tiempo'=> $this->faker->randomDigit,
        ];
    }
}
