<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Pregunta;

class Hacerpregunta extends Component
{
	public Pregunta $pregunta;
	public $indice;
	public $opciones;
	public $hint;
	public $opcion_id;
	public $regresiva;
	public $showq;
	
	public function mount($pregunta, $indice, $opciones, $hint, $showq)
	{
		$this->pregunta = $pregunta;
		$this->indice = $indice;
		$this->opciones = $opciones;
		$this->hint = $hint;
		$this->opcion_id = "";
		$this->regresiva = $pregunta->tiempo;
		$this->showq = $showq;
	}
	public function captura_respuesta($opcion_id=NULL)
	{
		if ($opcion_id !== null)
		{
			Log::error('Captura respuesta: '.$opcion_id);
			$this->emitUp('cerrar_pregunta');
		}
	}
	
    public function render()
    {
        return view('livewire.hacerpregunta');
    }
}
