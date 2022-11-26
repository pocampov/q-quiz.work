<?php

namespace App\Http\Livewire;

use Livewire\Component;

use \App\Models\Encuesta;
use \App\Models\Pregunta;
use \App\Models\Opcion;
use \App\Models\Publica;

class Preguntas extends Component
{
	public array $preguntas;
	public $encuesta;
	public $encuesta_id;
	public $titulo;
	public array $pregunta;
	public Publica $publica;

	
	public function mount($encuesta_id){
			$this->encuesta_id = $encuesta_id;
			$this->encuesta = Encuesta::find($encuesta_id);
			$this->titulo = $this->encuesta->title;
			$this->preguntas = $this->encuesta->preguntas()->where('tipo','O')->get()->toArray();
			$this->publica = $this->encuesta->publicaciones->where('activo')->first();
	}

    public function render()
    {
        return view('livewire.preguntas');
    }
}
