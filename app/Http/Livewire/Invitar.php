<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Publica;
use App\Models\Encuesta;
use App\Mail\Invitacion;


class Invitar extends Component
{
	use WithFileUploads;
	
	public Publica $publica;
	public Encuesta $encuesta;
	public $nombre;
	public $mail;
	public array $invitaciones;
	public $listado;

	protected $rules = [
        'nombre' => 'required|min:3',
        'mail' => 'required|email',
    ];
	protected $messages = [
    'mail.required_if' => 'Revise el correo electrónico, parece mal escrito',
	];
	public function mount(Request $request)
	{
		$this->publica = Publica::find($request->input('publica_id'));
		$this->encuesta = $this->publica->encuesta()->first();
		$this->invitaciones = [];
	}
	public function agregar()
	{
		$validatedData = $this->validate();
		$this->invitaciones[] = ['nombre' => $this->nombre, 'mail'=>$this->mail, 'estado'=>'✖'];
		$this->nombre = "";
		$this->mail = "";
	}
	public function borrar($key)
	{
		unset($this->invitaciones[$key]);
	}
	 public function upload_file()
    {
        $this->validate([
            'listado' => 'file|max:1024', // 1MB Max
        ]);
 
        $this->listado->store('listado');
		$file = $this->listado->readStream();
		$key = count($this->invitaciones);
		//$validatedData = $this->validate();
		while (($linea = fgetcsv($file, 500, ",")) !== FALSE) {
			//$this->invitaciones[$key] = ['nombre' => $linea[0], 'mail'=>$linea[1]];
			$this->invitaciones[$key]['nombre'] = $linea[0];
			$this->invitaciones[$key]['mail'] = trim($linea[1]);
			$this->invitaciones[$key]['estado'] = '✖';
			$key++;
		}
		fclose($file);
		$this->listado = null;
    }
	public function invitar()
	{
		foreach ($this->invitaciones as $key=>$invitacion)
		{
			if ($invitacion['estado'] == '✖')
			{	
				Mail::to($invitacion['mail'])->send(new Invitacion(
					$invitacion['nombre'], //Nombre destino
					$invitacion['mail'], //Correo destino
					$this->publica->launching, //Fecha programada del QQ $fecha
					$this->encuesta->user->name, //Nombre creador $creador
					$this->encuesta->title, //Titulo $qq_name
					$this->encuesta->description, //Descripcion del $qq_descripcion
					$this->publica->token,
					$this->publica->launching->diffInMinutes($this->publica->landing),
					$this->publica->launchingTZ
				));
				$this->invitaciones[$key]['estado'] = 'Enviado';
			}
		}
		$this->render();
	}
	public function salir()
	{
		return  redirect()->route('dashboard');
	}
    public function render()
    {
        return view('livewire.invitar');
    }
}
