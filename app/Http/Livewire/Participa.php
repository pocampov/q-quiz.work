<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Publica;
use App\Models\Participante;
use App\Models\EncuestaParticipante;

class Participa extends Component
{
	public $token = "";
	public $resultado;
	public $nickname;
	public $animo;
	public Participante $participante;
	public EncuestaParticipante $encuestaParticipante; 
	public $mitext_color;
	
	public function mount()
	{
		$this->resultado = "''";
		$this->mitext_color = "text-green-600";
	}
    public function render()
    {	
        return view('livewire.participa');
    }
	public function animo($animo)
	{
		$this->animo = $animo;
		
	}
	public function nickname_repetido($publica, $nickname)
	{
		$participantes = $publica->participantes();
		foreach ($participantes as $participante)
		{
			if ($participante->nickname == $nickname)
					return true;
		}
		return false;
	}
	public function valida_token($estado)
	{
		$this->animo($estado);
		$publica = Publica::where('token',$this->token)->first();
		if ($this->token == "")
			$this->resultado = "Escribe un QQ Token";
		elseif ($publica == null){
			$this->resultado = "Este QQ no existe";
		}
		elseif ($this->nickname == null){
			$this->resultado = "Ingresa un Nickname";
		}
		elseif ($this->nickname_repetido($publica,$this->nickname)) {
			$this->resultado = "Nickname ya utilizado";
		}
		elseif ($publica->activo) {
			$encuesta_id = $publica->encuesta_id;
			//$this->resultado = $encuesta->title;
			$this->participante = new Participante;
			$this->participante->nickname = $this->nickname;
			$this->participante->encuesta_id = $encuesta_id;
			$this->participante->publica_id = $publica->id;
			$this->participante->estado_inicial = $this->animo;
			$this->participante->save();
			$this->participante->refresh();
			if ($publica->xpregunta)
				return redirect()->route('play', ['publica'=>$publica, 'participante_id'=>$this->participante->id]);
			else //es programado
				return redirect()->route('play-programado', ['publica'=>$publica, 'participante_id'=>$this->participante->id]);				
		}
		elseif (!$publica->activo) {
			$this->mitext_color = "text-red-500";
			$this->resultado = "Este QQ ya no está activo";
		};
	}
}
