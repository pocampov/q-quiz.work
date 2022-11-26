<?php

namespace App\Http\Livewire\Mail;

use Livewire\Component;

class Convocatoria extends Component
{
	public $nombre;
	public $fecha;
	public $mail;
	
	public function mount($nombre="No llegó el dato", $mail=null, $fecha=null, $creador=null, $qq_name=null, $qq_descripcion=null)
	{
		$this->nombre = "NO hay informacion";
		$this->fecha = $fecha;
		$this->mail = $mail;
	}
    public function render()
    {
        return view('livewire.mail.convocatoria');
    }
}
