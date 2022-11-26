<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Http\Livewire\Traits\FuncionesGenerales;
	
class InsertaPregunta extends Component
{
	use FuncionesGenerales;
	
	public $creating;
	public $enunciado;
	public $tiempo;
	public $num_opciones;
	public Encuesta $encuesta;
	public array $opcion;
	public $tipo;
	public $num_pregunta;
	public $correcta;
	public $valor;
	public $captura_numero;
	
	protected $listeners = ['muestraPregunta'];
	protected $rules = [
        'enunciado' => 'required|min:3',
    ];
	
	public function mount(Encuesta $encuesta, $tipo)
	{
		$this->encuesta = $encuesta;
		$this->tipo = $tipo;// Solo puede ser "A" o "O"
		$this->creating = true;
		$this->opcion = [];	 
		$this->num_pregunta = 1;
		$this->tiempo = 10;
		$this->num_opciones = 3;
		$this->tiempo = 11;
		$this->valor = 0;
		$this->captura_numero = 4;
		$CAPTURA_NUMERO['OPCIONES'] = 2;
	}
	
	public function salir()
	{
		$this->creating = false;
		return  redirect()->route('dashboard');
	}	
	
	public function muestraPregunta(Encuesta $encuesta, $tipo)
	{
		\Log::alert("Llego a InsertaPregunta ".$tipo);
		$this->creating = true;
		$this->encuesta = $encuesta;
		$this->tipo = $tipo;
		$this->num_opciones = 3;
		$this->tiempo = 11;
	}

	public function inserta($seguir)
	{
		if ($this->enunciado == null)
			return;
		$pregunta = new Pregunta;
		$pregunta->encuesta_id = $this->encuesta->id;
		$pregunta->enunciado = $this->enunciado;
		$pregunta->tipo = $this->tipo;
		$pregunta->tiempo = $this->tiempo;
		$pregunta->save();
		for ($i=0;$i<$this->num_opciones; $i++)
		{
			$opcion = new Opcion;
			$opcion->pregunta_id = $pregunta->id;
			$opcion->text = $this->opcion[$i];
			$opcion->position = $i+1;
			$opcion->correcto = false; 
			if ($this->correcta == $i)
				$opcion->correcto = true;
			$opcion->save();
		}
		if ($seguir)
		{
			$this->num_opciones = null;
			$this->enunciado = null;
			$this->tiempo = null;
			$this->correcta = null;
			$this->muestraPregunta($this->encuesta, $this->tipo);
			$this->opcion = [];
		}
		else
		{
			$this->salir();
		}
		$this->num_pregunta = $this->encuesta->preguntas->count() + 1;
		
	}
	
    public function render()
    {
        return view('livewire.inserta-pregunta');
    }
}
