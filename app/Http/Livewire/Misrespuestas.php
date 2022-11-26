<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Publica;
use App\Models\Participante;
use App\Models\Pregunta;

class Misrespuestas extends Component
{
	public Participante $participante;
	public Publica $publica;
	public $preguntas;
	public $imagen;
	
	public function mount($publica_id, $participante_id)
	{
		$this->publica = Publica::find($publica_id);
		$this->participante = Participante::find($participante_id);
		//$this->preguntas = $this->publica->encuesta->preguntas;
		if ($this->publica->preguntas_lanzadas != "[]")
			$this->preguntas = Pregunta::whereIn('id', json_decode($this->publica->preguntas_lanzadas))->get();
		else
			$this->preguntas = [];
		$this->imagen = "/images/favicon-32x32.png";
	}
	public function volver()
	{
		return  redirect()->route('play',['publica'=>$this->publica, 'participante_id'=>$this->participante->id]);
	}
    public function render()
    {
        return view('livewire.misrespuestas');
    }
}
