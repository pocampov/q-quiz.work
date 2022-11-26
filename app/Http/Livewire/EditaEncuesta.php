<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opcion;

class EditaEncuesta extends Component
{
	public Encuesta $encuesta;
	public $num_pregunta;
	public array $num_opciones;
	public array $tiempo;
	public Pregunta $pregunta;
	public array $enunciado;
	public $categoria;
	public array $opcion;
	public $creating;
	public $edicion;
	public $fondo_input;
	public array $correcta;
	public array $opciones_iniciales;
	public $key;
	
	protected $rules = [
        'encuesta.title' => 'required|string|min:6',
		'encuesta.description' => 'required|string|min:6',
    ];
	public function mount($id)
	{
		$total_opciones = 5;
		$this->creating = true;
		$this->encuesta = Encuesta::find($id);
		$this->fondo_input ="";
		$this->preguntas = $this->encuesta->preguntas;
		$this->num_pregunta = 1;
		$this->edicion = "disabled";
		//$this->pregunta = $this->preguntas->first();
		$this->enunciado = $this->encuesta->preguntas->pluck('enunciado')->toArray();
		foreach ($this->preguntas as $key=>$pregunta)
		{
			$this->tiempo[$key] = $pregunta->tiempo;
			$this->opciones_iniciales[$key] = $pregunta->opciones->count();
			$this->opcion[$key] = [$pregunta->opciones->pluck('text')->toArray(),
					$pregunta->opciones->pluck('correcto')->toArray()
					];
			for ($i=count($this->opcion[$key][0]);$i<$total_opciones;$i++)
			{	
				array_push($this->opcion[$key][0], "");
				array_push($this->opcion[$key][1], 0);
			}
			$this->num_opciones[$key] = $total_opciones;
			// Averiguar posicion de opcion correcta	
			$opciones = $pregunta->opciones;
			$this->correcta[$key] = 0;
			foreach ($opciones as $key2=>$opcion)
			{
				if ($opcion->correcto)
				{
					$this->correcta[$key] = $key2;
				} 
			}
		}
		$this->key = 0;
	}
	public function methodl()
	{
		if ($this->edicion == "")
		{
			$this->opciones_iniciales[$this->key] -= 1;
		}
	}
	public function methodr()
	{
		if ($this->edicion == "")
		{
			$this->opciones_iniciales[$this->key] += 1;
		}
	}
	public function methodtl()
	{
		if ($this->edicion == "")
		{
			$this->tiempo[$this->key] -= 5;
		}
	}
	public function methodtr()
	{
		if ($this->edicion == "")
		{
			$this->tiempo[$this->key] += 5;
		}
	}
	public function edicion()
	{
		if ($this->edicion == "")
		{
			$this->fondo_input = "";
			$this->edicion = "disabled";
		}
		else
		{
			$this->fondo_input = "bg-green-50";
			$this->edicion = "";
		}
	}
	public function nueva_pregunta()
	{
		return  redirect()->route('inserta-pregunta',['encuesta'=>$this->encuesta->id, 'tipo'=>'O']);
	}
	public function salir()
	{
		$this->creating = false;
		return  redirect()->route('dashboard');
	}	
	public function correcta($key,$i)
	{
		$this->correcta[$key] = $i;
	}
	public function inserta($sigue)
	{
		foreach ($this->preguntas as $key=>$pregunta)
		{
			$pregunta->enunciado = $this->enunciado[$key];
			$pregunta->tiempo = $this->tiempo[$key];
			$opciones = $pregunta->opciones;
			foreach($this->opcion[$key][0] as $i=>$texto)
			{
				if ($texto != null)
				{
					if ( $i+1 > $opciones->count())
					{
						$opciones[$i] = new Opcion;
						$opciones[$i]->pregunta_id = $pregunta->id;
						$opciones[$i]->text = $texto;
					}else{
						$opciones[$i]->text = $texto;
					}
					if ($this->correcta[$key] == $i)
						$opciones[$i]->correcto = true;
					else
						$opciones[$i]->correcto = false;
					$opciones[$i]->save();
				}
			}
			$pregunta->save();
			$this->encuesta->save();
		}
		$this->salir();
	}
    public function render()
    {
        return view('livewire.edita-encuesta');
    }
}
