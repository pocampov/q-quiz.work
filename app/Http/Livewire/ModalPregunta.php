<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Participante;
use App\Models\Publica;
use App\Models\Respuesta;

class ModalPregunta extends Component
{
	public $preguntaId;
	public $creating;
	public $title;
	public $description;
	public array $opciones;
	public $actions;
	public $submit;
	public Pregunta $pregunta;
	public $consecutivo;
	public $respuesta_smultiple;
	public Participante $participante;
	public Opcion $opcion;
	public Publica $publica;
	public $hint = "";
	public $tiempo;
	
	protected $listeners = ['muestraPregunta','ocultaPregunta']; // Eventos lanzado por Play
	
	public function mount($preguntaId, $participante, $publica)
	{
		$this->preguntaId = $preguntaId;
		$this->creating = false;
		$this->opciones = [];
		$this->participante = $participante;
		$this->publica = $publica;
		$this->hint = "";
		$this->tiempo = 0;
	}
	public function testeo()
	{
		if ($this->tiempo <= 0) 
		{
			$this->creating = false;
			$this->emitTo('play','muestraPregunta',['estado'=>false]);
		}
		$this->tiempo = $this->tiempo - 0.5;
	}
	public function muestraPregunta($pregunta_id, $consecutivo)
	{
		if ($pregunta_id != null)
		{
			$this->hint = "";
			$this->creating = true;
			$this->emitTo('play','muestraPregunta',['estado'=>true]);
			\Log::alert('Modal: Se muestra pregunta');
			$this->preguntaId = $pregunta_id;
			$this->pregunta = Pregunta::find($this->preguntaId);
			$this->title = $this->pregunta->enunciado;
			$this->consecutivo = $consecutivo;
			$this->tiempo = $this->pregunta->tiempo;
			$this->opciones = $this->pregunta->opciones()->get()->toArray();
		}
	}
	public function ocultaPregunta()
	{
		$this->creating = false;
		$this->emitTo('play','muestraPregunta',['estado'=>false]);
	}
	public function captura_respuesta()
	{ 
		if (!$this->respuesta_smultiple == null)
		{
			$this->creating = false;
			$this->emitTo('play','muestraPregunta',['estado'=>false]);
			$opcion = Opcion::find($this->respuesta_smultiple);
			$respuesta = New Respuesta;
			$respuesta->participante_id = $this->participante->id;
			$respuesta->pregunta_id = $this->pregunta->id;
			$respuesta->respuesta = $opcion->id;
			$respuesta->publica_id = $this->publica->id;
			$respuesta->save();
			$this->respuesta_smultiple = null;
			//$this->emit('muestraPantalla', false); //Leido por Play
		} else
		{
			$this->hint = "Debe marcar una opción";
		}
	}
    public function render()
    {
        return view('livewire.modal-pregunta');
    }
}
