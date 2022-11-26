<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OpcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text'=>$this->faker->sentence(),
			'position'=>$this->faker->randomDigit(),
			'correcto'=>$this->faker->boolean(),
        ];
    }
}
