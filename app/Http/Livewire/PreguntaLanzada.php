<?php

namespace App\Http\Livewire;

use DateTime;
use DateTimeZone;
use Livewire\Component;
use App\Models\Pregunta;
use App\Models\Publica;
use App\Models\Encuesta;
use App\Models\EncuestaParticipante;

class PreguntaLanzada extends Component
{
	public Pregunta $pregunta;
	public Publica $publica;
	public Encuesta $encuesta;
	public $participantes;
	public $forma;
	public $preguntas;
	public $reloj;
	public $horario;
	public $estado;
	public $periodo;
	public $active;
	public $icon;
	public $color_box;
	public $token;
	public $estado_inicial;
	
	public function mount($publica_id,$forma)
	{
		$this->publica = Publica::find($publica_id);
//		$this->publica->landing->setTimezone(new DateTimeZone($this->publica->launchingTZ));
		$this->publica->launching->setTimezone(new DateTimeZone($this->publica->launchingTZ));
		$this->token = $this->publica->token;
		$this->encuesta = $this->publica->encuesta;
		$this->preguntas = $this->encuesta->preguntas;
		//$this->indice = 0;
		//$this->pregunta = $this->preguntas[$this->indice];
		$this->forma = $forma;
		$this->participantes = $this->publica->participantes();
		
		$this->horario = $this->programa_preguntas($this->publica);
		$this->reloj = now($this->publica->launchingTZ)->format('H:i:s');
		$this->active = true;
		$this->estado = -1;
		$this->periodo = "500ms";
		$this->icon = "tower24.gif";
		$this->color_box = "";
		$this->actualiza_estados();
	}
	public function temporizador()
	{
		$this->participantes = $this->publica->participantes();
		$this->actualiza_estados();
		$this->reloj = now($this->publica->launchingTZ)->format('H:i:s');//Actualiza el relojito
		$i = $this->pregunta_actual();
		$j = $this->estado;

		if (is_numeric($i) and $j != $i )
		{
			$this->pregunta = $this->preguntas[$i];
			$this->publica->pregunta_lanzada_id = $this->pregunta->id;
			$this->publica->consecutivo = $i;
			//$this->publica->save();
			$this->estado = $i;
		}
		
		if ($i === "ended")
		{
			$this->active = false;
			$this->periodo = "3600s";
			$this->icon = "radio-tower.svg";
			$this->color_box = "bg-emerald-300";
			$this->publica->activo = false;
			$this->publica->pregunta_lanzada_id = null;
			//$this->publica->save();
			$this->estado = -2;
			return $i;
		}
		if ($i === "soon")
			return $i;
		//$this->indice = $i;
	}
	
	public function programa_preguntas($publica)
	{
		$preguntas = $publica->encuesta->preguntas;
		$nuevo_datetime = new DateTime($publica->launching,new dateTimeZone($publica->launchingTZ));
		foreach ($preguntas as $i=>$pregunta)
		{
			$programa_pregunta['inicio'][$i] = $nuevo_datetime->format('Y-m-d H:i:s');
			$programa_pregunta['fin'][$i] = $nuevo_datetime->modify( '+'.$pregunta->tiempo.' seconds')->format('Y-m-d H:i:s');
		}
		if ($preguntas->count() == 0)
			$programa_pregunta = [];
		return $programa_pregunta;
	}
	public function pregunta_actual()
	{
		//Dada la hora devuelve el indice de la pregunta
		$ultimo = end($this->horario['fin']);
		$primero = $this->horario['inicio'][0];
		if ( strtotime(now($this->publica->launchingTZ)->format('Y-m-d H:i:s')) >= strtotime($ultimo) )
			return "ended"; // La prueba ya termino
		if ( strtotime(now($this->publica->launchingTZ)->format('Y-m-d H:i:s')) < strtotime($primero) )
			return "soon"; // La prueba pronto comenzara
		foreach ($this->horario['inicio'] as $i=>$inicio )
		{
			if (strtotime(now($this->publica->launchingTZ)->format('Y-m-d H:i:s')) >= strtotime($primero) and strtotime(now($this->publica->launchingTZ)->format('Y-m-d H:i:s')) <= strtotime($this->horario['fin'][$i]))
				return $i;
		}
		return "Caramba!";
	}
	public function actualiza_estados()
	{
		foreach ($this->participantes as $i=>$participante)
		{
			$this->estado_inicial[$i] = $this->lee_estado($this->publica->id,$participante->id);
		}
	}
	public function lee_estado($publica_id,$participante_id)
	{
		$estado_inicial = EncuestaParticipante::where([
			['publica_id','=',$publica_id],
			['participante_id','=',$participante_id]
			])->get();
		return  $estado_inicial->first()->estado_inicial;
	}

    public function render()
    {
        return view('livewire.pregunta-lanzada');
    }
}
