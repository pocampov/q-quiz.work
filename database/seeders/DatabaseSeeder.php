<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Publica;
use App\Models\Participante;
use App\Models\EncuestaParticipante;
use App\Models\Respuesta;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		echo ("=======Crea Usuarios y encuestas========== \n");
        $users = User::factory(10)->create();
		$encuestas = Encuesta::factory(10)->make();
		foreach ($encuestas as $encuesta){
			$user = $users->random();
			$encuesta->user_id = $user->id;
			$encuesta->save();
		}
		
		echo ("=======Crea preguntas========== \n");
		$preguntas = Pregunta::factory(100)->make();
		foreach ($preguntas as $pregunta){
			$encuesta = $encuestas->random();
			$pregunta->encuesta_id = $encuesta->id;
			$pregunta->tiempo = rand(12,30);
			$pregunta->save();
			$opciones = Opcion::factory(5)->make();
			foreach ($opciones as $opcion) {
				$opcion->pregunta_id = $pregunta->id;
				$opcion->save();
			}
		}

		echo ("=======Crea publicaciones y participante ========== \n");
		foreach ($encuestas as $encuesta){

			$publica = Publica::factory()->make();
			$publica->encuesta_id = $encuesta->id;
			$publica->save();
			$participante = Participante::factory()->make();
			$participante->encuesta_id = $encuesta->id;
			$participante->publica_id = $publica->id;
			$participante->save();
			
			echo ("=======Crea Respuestas ========== \n");
			$preguntas1 = $preguntas->where('encuesta_id', $encuesta->id);
			foreach ($preguntas1 as $pregunta) {
				$respuesta = Respuesta::factory()->make();
				$respuesta->pregunta_id = $pregunta->id;
				$respuesta->participante_id = $participante->id;
				$respuesta->save();
			}
		}
    }
}


















