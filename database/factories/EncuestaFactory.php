<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EncuestaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=> $this->faker->words(5, true),
			'description'=> $this->faker->words(20, true),
			'categoria'=> $this->faker->words(1, true),
        ];
    }
	public function participantes()
	{
		return $this->belongsToMany(Participante::class);
	}
}
