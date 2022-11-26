<?php

namespace App\Http\Livewire;

use DateTime;
use DateTimeZone;
use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Publica;
use Illuminate\Support\Carbon;
use App\Models\Participante;


class Lanza extends Component
{
	public Encuesta $encuesta;
	public $time;
	public $day;
	public $zonas;
	public $timezone;
	public DateTime $nueva_fecha;
	public $tipo;
	public $tzona;
	public $label_boton;
	public $apagar;
	public $duracion;
	public $duracion_minima;
	public DateTime $activo_hasta;
	//Para la prueba
	public $creating;

	
	public function mount($encuesta_id)
	{
		$this->encuesta = Encuesta::find($encuesta_id);
		$this->zona();

		$this->timezone = date_default_timezone_get();
		//$this->nueva_fecha = null;
		$this->token = null;
		$this->tipo = 'Por Pregunta';
		$this->tzona = "";
		$this->label_boton = "LANZAR AHORA";
		$this->apagar = "disabled";
		$preguntas = $this->encuesta->preguntas;
		$total = 0;
		foreach ($preguntas as $pregunta)
		{
			$total = $total + $pregunta->tiempo;
		}
		$total = $total + 300;
		$total = $total / 60;
		$this->duracion_minima = round($total);
		$this->duracion = $this->duracion_minima;
		$this->activo_hasta = new DateTime("0-0-0 0:0:0", new DateTimeZone($this->timezone));
		
		//Para la prueba
		$this->creating = false;
	}
	public function wait($sec)
	{
		logger("Inicia: ".now());
		$this->creating = true;
		time_sleep_until(time()+$sec);
		$this->creating = false;
		logger("Termina: ".now());
	}
	public function ahora()
	{
		//date_default_timezone_set($this->timezone);
		$today = new DateTime("now", new DateTimeZone($this->timezone));
		//$this->time = $today->format('H:i');
		$this->day = $today->format('Y-m-d');
		
	}
	public function save()
	{
		$this->actualiza();

		$this->nueva_fecha = new Carbon($this->day." ".$this->time." ".$this->timezone);
		if ($this->label_boton == "LANZAR AHORA")
			$this->nueva_fecha = new Carbon("now", new DateTimeZone($this->timezone));
		$publica = new Publica;
		$publica->encuesta_id = $this->encuesta->id;
		$publica->token = $this->token(7);
		$publica->activo = true;
		$publica->launching = $this->nueva_fecha;
		$publica->launchingTZ = $this->timezone;
		$publica->landing = $this->activo_hasta;
		if ($this->tipo=="Todo")
			$publica->xpregunta = false;
		else
			$publica->xpregunta = true;
		$publica->save();
		$this->token = $publica->token;
		// Si es xpregunta va a 'pregunta-lanzada' sino muestra todas las preguntas (lanzamiento-manual.blade) para ir lanzando
		if (!$publica->xpregunta)
			return  redirect()->route('invitar',[
				'publica_id'=>$publica->id]);
		else
		{
			return  redirect()->route('lanzamiento-manual', [
				'publica_id'=>$publica->id]);
		}
	}
	public function actualiza()
	{
		$tz = new DateTimeZone($this->timezone);
		$today = new Carbon($this->day." ".$this->time, $tz);
		$this->activo_hasta = $today->modify('+'.strval($this->duracion).' minute');
		$this->activo_hasta->shiftTimezone($tz);
	}
	public function agendar()
	{
		if ($this->label_boton == "LANZAR AHORA")
		{
			$this->label_boton = "PROGRAMAR";
			$this->tipo = 'Todo';
			$this->apagar = "";
		}else
		{
			$this->label_boton = "LANZAR AHORA";
			$this->tipo = 'Por Pregunta';
			$this->apagar = "disabled";
		}
		$tz = new DateTimeZone($this->timezone);

		$today = new DateTime($this->day." ".$this->time, $tz);
		$this->activo_hasta = $today->modify('+'.strval($this->duracion).' minute');
	}
    public function render()
    {
        return view('livewire.lanza');
    }
	function token($long)
	{
		$token ="";
		$cadena = "abcdefghijklmnopqrstuvwxyz0123456789";
		$token = substr(str_shuffle($cadena),1,$long);
		return $token;
	}
	function zona()
	{
		$this->zonas = DateTimeZone::listIdentifiers();
	}
}