<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTime;
use DateTimeZone;
use DateInterval;
use Livewire\Component;
use App\Models\Publica;
use App\Models\Participante;
//use App\Models\EncuestaParticipante;

class PlayProgramado extends Component
{
	public $imagen;
	public $pregunta;
	public $indice;
	public $opciones;
	public $opcion_id;
	public $mostar_respuestas;
	public $tiempo_responder;
	public $efecto_ganar;
	public $wins;
	public $losts;
	public $unanswered;
	public $efecto_perder;
	public $promedio_aciertos;
	public $promedio_erros;
	public $mi_puesto;
	public $comienza;
	public $termina;
	public $timezone;
	public $timetostart;
	public $process;
	public $siguiente;
	public $mostrar_respuestas;
	public $tiempo_mostrar_respuestas;
	public $time_reload;
		
	public function mount(Publica $publica, $participante_id)
	{
		$this->imagen = "/images/qq-play.svg";
		$this->publica = $publica;
		$this->participante = Participante::find($participante_id);
		$this->estado_inicial = $this->participante->estado_inicial;		
		$this->estado = "Iniciando ....";
		$this->preguntas = $this->publica->encuesta->preguntas;
		$this->pregunta = $this->preguntas[0];
		$this->indice = -1;
		$this->opciones = $this->preguntas->first()->opciones;
		$this->tiempo_responder = 0;
		$this->wins = "emoji_people ";
		$this->losts = "directions_walk ";
		$this->unanswered = "alarm_off ";
		$this->efecto_ganar = "";
		$this->efecto_perder = "";	
		$this->promedio_aciertos = 0;
		$this->promedio_erros = 0;
		$this->mi_puesto = 0;
		$this->comienza = $this->publica->launching->shiftTimezone($this->publica->launchingTZ);
		$this->termina = $this->publica->landing->shiftTimezone($this->publica->launchingTZ);
		$this->timezone = 'America/Bogota';
		$this->timetostart = 0;
		$this->process = 0;
		$this->siguiente = true;
		$this->mostrar_respuestas = "disabled";
		$this->tiempo_mostrar_respuestas = -1;

	}
	public function establece_final()
	{
	//Recarga la página al cumplir el tiempo
		$date = new Carbon("now", new DateTimeZone($this->timezone) ); 
		$this->time_reload = $date->diffInSeconds($this->termina);
		$this->emit('reloadToEnd', $this->time_reload);
	}
	public function muestra_pregunta()
	{
		if ($this->siguiente and $this->estado == "ONAIR" and $this->indice < $this->preguntas->count()-1) 
		{
			$this->indice++;
			$this->opcion_id = null;
			$this->pregunta = $this->preguntas[$this->indice];
			$this->tiempo = $this->pregunta->tiempo;
			$this->opciones = $this->pregunta->opciones;
			$this->emit('startCountDown', $this->pregunta->tiempo, $this->indice);
			$this->siguiente = false;
		}
	}
	public function muestra_estado()
	{
		$this->emit('TimeZone: '.$this->timezone);
		$date = new Carbon("now", new DateTimeZone($this->timezone) ); 
		$this->tiempo_mostrar_respuestas = $this->termina->format('d-M-Y h:i:s A');
		if ($date < $this->comienza)
		{
			$this->estado = "SOON";
			$this->imagen = "/images/qq-wait.svg";
			$this->timetostart = $date->diff($this->comienza, true)->format('%H:%i:%s');
		}
		if ( $date->isBetween($this->comienza, $this->termina))
		{
			$this->estado = "ONAIR";
			$this->muestra_pregunta();
			$this->imagen = "/images/qq-play.svg";
		}
		if ($date > $this->termina)
		{
			$this->estado = "ENDED";
			$this->imagen = "/images/qq-sleep.svg";
			$this->mostrar_respuestas = "";
		}		
	}
	public function captura_respuesta($valor_final=NULL)
	{
		$this->emit('cancela');
		$this->emit('log','Opcion capturada: '.$this->opcion_id);
		$this->siguiente = true;
		$this->muestra_pregunta();
	}
	public function misrespuestas()
	{
		
	}
    public function render()
    {
        return view('livewire.play-programado');
    }
}
