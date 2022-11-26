<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Question extends Component
{
	public $opciones;
	public $hint;
	public $respuesta_smultiple;
	
	public function mount($opciones)
	{
		$this->opciones = $opciones;
		$this->hint = "";
	}
		public function captura_respuesta()
	{ 
		if (!$this->respuesta_smultiple == null)
		{
			$this->creating = false;
			$respuesta = New Respuesta;
			$respuesta->participante_id = $this->participante->id;
			$respuesta->pregunta_id = $this->pregunta->id;
			$respuesta->respuesta = $this->respuesta_smultiple;
			$respuesta->publica_id = $this->publica->id;
			$respuesta->save();
			$this->respuesta_smultiple = null;
		} else
		{
			$this->hint = "Debe marcar una opción";
		}
	}
    public function render()
    {
        return view('livewire.question');
    }
}
