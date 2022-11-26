<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Encuesta;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Livewire\InsertaPregunta;

class Misqq extends Component
{
	public Encuesta $encuesta;
	public Collection $encuestas;
	public Encuesta $nueva_encuesta;
	public $title;
	public $description;
	public $categoria;
	public $pregunta_tipo;
	public $creating;
	public $alert_title;
	public $alert_text;
	public $alert_icon;
	public $alert_boton1;
	public $alert_boton2;
	public $alert_accion1;
	public $alert_parametro;
	public $mostar_formulario;
	public $muestra;
	
	public function mount()
	{
		$this->creating = false;
		$this->mostrar_formulario = false;
		$user_id = auth()->id();
		$this->encuestas = Encuesta::where('user_id', $user_id)->orderByDesc('id')->get();
		$total_encuestas = $this->encuestas->count();
		if ($total_encuestas == 0)
		{
			$encuesta1= new Encuesta;
			$encuesta1->title = "AUN NO HAS CREADO QQs";
			$this->encuestas->push($encuesta1);
		}
		$this->pregunta_tipo = "O";
		$this->title = "";
		$this->alert_title ="ELIMINAR PERMANENTEMENTE";
		$this->alert_text = "Esta seguro de eliminar __";
		$this->alert_icon ="alert48.svg";
		$this->alert_boton1 = "Si borralo";
		$this->alert_boton2 = "Mejor no";
		$this->alert_accion1 = "";
		$this->alert_parametro = 0;
		$this->nueva_encuesta = new Encuesta;
		$this->muestra = false;
	}
	
	public function submit(Request $request)
	{

		if ($this->title != "")
		{
			$this->nueva_encuesta->title = $this->title;
			$this->nueva_encuesta->description = $this->description;
			$this->nueva_encuesta->categoria = $this->categoria;
			$this->nueva_encuesta->user_id = auth()->id();
			//$this->nueva_encuesta->tipo = $this->pregunta_tipo;
			$this->nueva_encuesta->save();			
			$this->encuestas = Encuesta::where('user_id', auth()->id())->orderByDesc('id')->get();
			$this->mostrar_formulario = true;
			return  redirect()->route('inserta-pregunta',['encuesta'=>$this->nueva_encuesta->id, 'tipo'=>$this->pregunta_tipo]);
		}
	}
	public function confirma_borrar($id)
	{
		$this->alert_parametro = $id;
		$this->alert_text = "Esta seguro de eliminar ".Encuesta::find($id)->title;
		$this->creating = true; // Muestra el modal
	}
	public function edita($id)
	{
		$encuesta = Encuesta::find($id);
		if ($encuesta->preguntas->count() == 0)
		{
			$this->nueva_encuesta = $encuesta;
			$this->pregunta_tipo = "O";
			$this->mostrar_formulario = true;
			return  redirect()->route('inserta-pregunta',['encuesta'=>$this->nueva_encuesta->id, 'tipo'=>$this->pregunta_tipo]);
		}
		else
		{
			\Log::alert('Tiene preguntas');
			return  redirect()->route('editaencuesta',['id'=>$id]); //view('livewire.edita-encuesta',[$id]);
		}
		//si no tiene preguntas va a $this->mostrar_formulario = true;
		
	}
	public function borrar($encuesta_id)
	{
		$encuesta = Encuesta::find($encuesta_id);
		$encuesta->borrar();
		$this->encuestas = Encuesta::where('user_id', auth()->id())->orderByDesc('id')->get();
		$this->creating = false;
	}
    public function render()
    {
        return view('livewire.misqq');
    }
}
