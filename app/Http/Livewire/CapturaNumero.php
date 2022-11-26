<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\Traits\FuncionesGenerales;

class CapturaNumero extends Component
{
	use FuncionesGenerales;
		
	public $valor_inicial;
	public $incremento;
	public $valor;
	public $title;
	
	public function mount($valorinicial, $incremento, $title)
	{
		$this->valor_inicial = $valorinicial;
		$this->incremento = $incremento;
		$this->valor = $this->valor_inicial;
		$this->title = $title;
	}
    public function render()
    {
        return view('livewire.captura-numero');
    }
}
