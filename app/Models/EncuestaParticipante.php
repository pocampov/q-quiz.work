<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestaParticipante extends Model
{
    use HasFactory;
	
	protected $table = 'encuesta_participante';

	public function participante()
    {
        return $this->belongsTo(Participante::class);
    }
	public function encuesta()
    {
        return $this->belongsTo(Encuesta::class);
    }
	public function participantes()
    {
        return $this->belongsToMany(Participante::class);
    }
}