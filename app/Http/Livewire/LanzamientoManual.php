<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Publica;
use App\Models\Pregunta;
use App\Models\Participante;
use App\Models\Opcion;
use App\Models\Respuesta;

class LanzamientoManual extends Component
{
	public $imagen;
	public array $tiempo;
	public $time;
	public $width;
	public $tiempo_inicio;
	public $tiempo_refresco;
	public $key;
	public array $ignition_image;
	public Publica $publica;
	public $preguntas;
	public $desactivado;
	public Pregunta $pregunta;
	public $participantes;
	public array $textcolor;
	public $user = "man";
	public $userwin = "emoji_people";
	public $userlost = "directions_walk";
	public array $user_icon;
	public array $preguntas_lanzadas;
	public $lider_board;

	public function mount(Request $request)
	{
		$this->imagen = "/images/manualLaunch.png";
		$this->time = 0;
		$this->width = 0;
		$this->tiempo_inicio = now();
		$this->tiempo_refresco = "6000ms";
		$this->publica = Publica::find($request->input('publica_id'));
		$this->participantes = $this->publica->participantes;
		$this->preguntas = $this->publica->encuesta->preguntas;
		for ($i=0;$i<500;$i++)
		{
			$arr[] = $i;
		}
		$this->textcolor = array_fill_keys($arr, "text-amber-500");
		$this->user_icon = array_fill_keys($arr, "man");
		foreach ($this->preguntas as $key=>$pregunta)
		{
			if($pregunta->tiempo)
				$this->tiempo[$key] = $pregunta->tiempo;
			else
				$this->tiempo[$key] = 10;
			$this->ignition_image[$key] = "🏌";
		}
		$this->desactivado = "";
		$this->preguntas_lanzadas = json_decode($this->publica->preguntas_lanzadas);
		$this->lider_board = $this->publica->liderboard();
	}
	public function plus($key)
	{
		$this->tiempo[$key] += 10;
		$this->preguntas[$key]->tiempo = $this->tiempo[$key];
		$this->preguntas[$key]->save();
	}
	public function minus($key)
	{
		if ($this->tiempo[$key]>=10)
		{
			$this->tiempo[$key] -= 10;
			$this->preguntas[$key]->tiempo = $this->tiempo[$key];
			$this->preguntas[$key]->save();
		}
	}

	public function ignition($key)
	{ 
			$this->publica->consecutivo++;
			$this->publica->pregunta_lanzada_id = $this->preguntas[$key]->id;
			$this->publica->save();
			$this->publica->refresh();
			$this->emitSelf('log','Se lanzo ignition');
			$this->tiempo_inicio = now();
			$this->key = $key;
			$this->pregunta = $this->preguntas[$key];
			$this->desactivado = "opacity-10";
	}
	public function termina_pregunta()
	{
		$this->ignition_image[$this->key] = "✔";
		$this->desactivado = "";
		$this->publica->ultimo_contestado = $this->publica->pregunta_lanzada_id;
		$this->preguntas_lanzadas[] = $this->publica->pregunta_lanzada_id;
		$this->publica->preguntas_lanzadas = json_encode($this->preguntas_lanzadas);
		$this->publica->pregunta_lanzada_id = null;
		$this->publica->save();
		$this->publica->refresh();
		foreach ($this->participantes as $i => $participante)
		{
			$this->textcolor[$i] = "text-ambar-500";
			$this->user_icon[$i] = $this->user;
			//Si no contestó pregunta lo registra
			$respuesta = Respuesta::where('participante_id',$participante->id)->where('pregunta_id', $this->pregunta->id)->first();
			//Log::alert('Duplicados? pregunta_id:'.$this->pregunta->id. " participante->id:".$participante->id);
			if ($respuesta == null)
			{
				$respuesta = New Respuesta;
				$respuesta->participante_id = $participante->id;
				$respuesta->pregunta_id = $this->pregunta->id;			
				//$respuesta->publica_id = $this->publica->id;
				$respuesta->save();
			}
		}
	}
	public function actualiza_estado()
	{
		$this->participantes = $this->publica->participantes;
		if ($this->key and $this->width < 100 and $this->desactivado != "")
		{
			foreach ($this->participantes as $i => $participante)
			{
				$this->textcolor[$i] = "text-ambar-500";
				if ($participante->ultimo_contestado == $this->publica->pregunta_lanzada_id)
				{
					$this->textcolor[$i] = "text-green-500";
					$opcion_id = $participante->respuesta_opcion_id($this->publica->id,$this->publica->pregunta_lanzada_id); 
					if (Opcion::find($opcion_id)->correcto)
					{
						$this->user_icon[$i] = $this->userwin;
					}else
					{
						$this->textcolor[$i] = "text-red-500";
						$this->user_icon[$i] = $this->userlost;
					}
				}
				
			}
		}
		$this->lider_board = $this->publica->liderboard();
	}
    public function render()
    {
        return view('livewire.lanzamiento-manual');
    }
}
