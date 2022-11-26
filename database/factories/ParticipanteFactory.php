<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipanteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nickname' => $this->faker->word(),
			'estado' => $this->faker->sentence(6),
        ];
    }
	
	public function encuestas()
	{
		return $this->belongsToMany(Encuesta::class);
	}
}
