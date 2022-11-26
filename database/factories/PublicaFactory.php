<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PublicaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token'=>$this->faker->lexify('???????'),
			'activo'=>$this->faker->boolean(),
        ];
    }
}
