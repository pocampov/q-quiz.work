<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EncuestaParticipante;
use App\Models\Publica;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Respuesta;

class Encuesta extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'title',
		'description',
		'categoria',
	];
	public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
	public function publicaciones()
    {
        return $this->hasMany(Publica::class);
    }
	public function user()
    {
        return $this->belongsTo(User::class);
    }
	public function participantes()
    {
        return $this->belongsToMany(Participante::class);
    }
	public function opciones()
	{
		return $this->hasManyThrough(Opcion::class, Pregunta::class);
	}
	public function respuestas()
	{
		return $this->hasManyThrough(Respuesta::class, Pregunta::class);
	}
	public function borrar()
	{
		$opciones = $this->opciones;
		$respuestas = $this->respuestas;
		$publicaciones = $this->publicaciones;
		$preguntas = $this->preguntas;
		$encuestaparticipantes = EncuestaParticipante::where('encuesta_id',$this->id)->get();
		
		foreach ($opciones as $opcion)
			$opcion->delete();
		foreach ($respuestas as $respuesta)
			$respuesta->delete();
		foreach ($publicaciones as $publicacion)
			$publicacion->delete();
		foreach ($preguntas as $pregunta)
			$pregunta->delete();
		foreach ($encuestaparticipantes as $encuestaparticipante)
			$encuestaparticipante->delete();
		$this->delete();
	}
}
