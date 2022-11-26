<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'enunciado',
		'tipo',
	];
	public function opciones()
    {
        return $this->hasMany(Opcion::class);
    }
	public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
	public function encuesta()
    {
        return $this->belongsTo(Encuesta::class);
    }
	
}
