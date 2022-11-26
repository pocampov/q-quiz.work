<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pregunta;
use App\Events\ActivaPregunta;

class PreguntaItem extends Component
{
	public array $opciones;
	public Pregunta $pregunta;
	public $brillo_boton;
	public $label_boton;
	
	public function mount($pregunta_id)
	{
		$this->pregunta = Pregunta::find($pregunta_id);
		$this->opciones = $this->pregunta->opciones()->get()->toArray();
		$this->label_boton = "LANZAR PREGUNTA";
		$this->brillo_boton = 700;
	}
	
	public function activaPregunta($preguntaId)
	{
		\Log::debug($preguntaId);
		event(new ActivaPregunta($preguntaId)); //Evento escuchado por Play
		$this->brillo_boton = 500;
		$this->label_boton = "PREGUNTA LANZADA";
	}
    public function render()
    {
        return view('livewire.pregunta-item');
    }
}
