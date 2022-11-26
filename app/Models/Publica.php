<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Encuesta;
use App\Models\Participante;
use App\Models\Respuesta;

class Publica extends Model
{
    use HasFactory;
	
	protected $fillable = [
		'token',
		'activo',
	];
	protected $dates = [
        'landing',
		'launching'
    ];


	public function encuesta()
	{
        return $this->belongsTo(Encuesta::class);
	}
	public function participantes()
	{
		//return Participante::where('publica_id',$this->id)->get();
		return $this->hasMany(Participante::class);
	}
	public function respuestas()
	{
		return $this->hasManyThrough(Respuesta::class, Participante::class);
	}
	public function aciertos_totales()
	{
		$aciertos = 0;
		foreach ($this->respuestas as $respuesta)
		{
			if ($respuesta->correcta)
				$aciertos++;
		}
		return $aciertos;
	}
	public function erros_totales()
	{
		$erros = 0;
		$participantes = $this->participantes();
		foreach ($this->respuestas as $respuesta)
		{
			if ($respuesta->correcta === false)
				$erros++;
		}
		return $erros;
	}
	public function liderboard()
	{
		$participantes = $this->participantes;
		if ($participantes->count() > 0)
		{
			foreach ($participantes as $key=>$participante)
			{
				$respuestas = $participante->respuestas();
				$puesto = 0;
				foreach ($respuestas as $respuesta)
				{
					if ($respuesta->correcta())
						$puesto = $respuesta->puesto + $puesto;
					else
						$puesto = 1000 + $puesto;
				}
				$estado_inicial = $participante->estado_inicial;
				$aciertos[] = array('id'=>$participante->id,'nickname'=>$participante->nickname,'estado_inicial'=>$estado_inicial, 'aciertos'=>$participante->aciertos(),'erros'=>$participante->erros(), 'puesto'=>$puesto);
			}
			$puestos  = array_column($aciertos, 'puesto');
			array_multisort($puestos, SORT_ASC, $aciertos);		
			return $aciertos;
		}
		else 
		{
			return null;
		}
	}
	public function nickname_repetido($nick, $encuesta_id)
	{
		$participantes = Participante::where('nickname', $nick)->where('encuesta_id',$encuesta_id)->get();
		if ($participantes->count() == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
