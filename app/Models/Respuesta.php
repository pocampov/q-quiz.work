<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Participante;
use App\Models\Pregunta;
use App\Models\Opcion;

class Respuesta extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'respuesta',
	];
	
	public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
	public function participante()
	{
		return $this->belongsTo(Participante::class);
	}
	public function publica()
	{
		return $this->belongsTo(Publica::class);
	}
	public function correcta()
	{
		if ($this->respuesta !== null)
		{
			if (Opcion::find($this->opcion_id)->correcto)
				return true;
			else
				return false;
		}else
			return null;
	}
}
