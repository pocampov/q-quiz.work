<?php
namespace App\Http\Livewire\Traits;
use Illuminate\Http\Request;


trait FuncionesGenerales
{
	public array $CAPTURA_NUMERO;
	
	public function plus($valor, $incremento, $title)
	{
		$valor += $incremento;
		$this->CAPTURA_NUMERO[$title] = $valor;
	}
	public function minus($variable, $valor, $decremento)
	{
		if ($variable - $decremento >= 0)
		{
			$variable -= $decremento;
		}
		return $variable;
	}
}