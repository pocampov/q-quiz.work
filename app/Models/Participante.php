<?php

namespace App\Models;

use App\Models\Encuesta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Opcion;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Publica;

class Participante extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'nickname',
		'estado',
	];
	
	public function encuesta()
	{
		return $this->belongsTo(Encuesta::class);
	}
	public function publicacion()
	{
		return $this->belongsTo(Publica::class);
	}
	public function respuestas()
	{
		return Respuesta::where('participante_id',$this->id)->get();
	}
	public function correcta($publica_id,$pregunta_id)
	{
		$respuesta = Respuesta::where('participante_id',$this->id)->where('pregunta_id',$pregunta_id)->get();
		$opcion_id = $respuesta[0]->opcion_id;
		if ($opcion_id != null)
			$es_correcta = Opcion::find($opcion_id)->correcto;
		else
			$es_correcta = false;
		if ($es_correcta)
			$respuesta = 'check_circle';
		else
			$respuesta = "☹";
		return $respuesta;
	}

	public function respuesta($publica_id, $pregunta_id)
	{
		$respuesta = Respuesta::where('participante_id',$this->id)->where('pregunta_id',$pregunta_id)->get();
		if ($respuesta->count() == 0)
			return "SIN RESPUESTA";
		else {
			$opcion_id = $respuesta[0]['opcion_id'];
			if ($opcion_id != null)
			{
				$opcion = Opcion::find($opcion_id);
				return $opcion->text;
			}
			else
				return "Pregunta abierta";
		}
		return $opcion_id;
	}
	public function respuesta_opcion_id($publica_id, $pregunta_id)
	{
		$respuesta = Respuesta::where('participante_id',$this->id)->where('pregunta_id',$pregunta_id)->get();
		if ($respuesta->count() == 0)
			return null;
		else {
			$opcion_id = $respuesta[0]['opcion_id'];
		}
		return $opcion_id;
	}
	public function aciertos()
	{
		$buenas = 0;
		$respuestas = Respuesta::where('participante_id',$this->id)->get();
		foreach ($respuestas as $respuesta)
		{
			if ($respuesta->correcta())
				$buenas++;
		}
		return $buenas;
	}
	public function erros()
	{
		$erro = 0;
		$respuestas = Respuesta::where('participante_id',$this->id)->get();
		foreach ($respuestas as $respuesta)
		{
			if ($respuesta->correcta() === false)
				$erro++;
		}
		return $erro;
	}
	public function sincontestar()
	{
		$nulos = 0;
		foreach ($this->respuestas() as $respuesta)
		{
			if ($respuesta->respuesta === null and $respuesta->opcion_id === null)
				$nulos++;
		}
		return $nulos;
	}
}
