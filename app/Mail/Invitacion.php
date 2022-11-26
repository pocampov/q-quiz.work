<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invitacion extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre; 
	public $mail; 
	public $fecha; 
	public $creador; 
	public $qq_name; 
	public $qq_descripcion;
	
    public function __construct($nombre, $mail, $fecha, $creador, $qq_name, $qq_descripcion, $token, $lapso, $launchingTZ)
    {
        $this->nombre = $nombre;
		$this->mail = $mail;
		$this->fecha = $fecha;
		$this->creador = $creador; 
		$this->qq_name = $qq_name; 
		$this->qq_descripcion = $qq_descripcion;
		$this->token = $token;
		$this->lapso = $lapso;
		$this->launchingTZ = $launchingTZ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->nombre.' estás invitado por 🦉 '.$this->creador)->view('livewire.Mail.convocatoria')->with([
                        'nombre' => $this->nombre,
                        'mail' => $this->mail,
						'fecha' => $this->fecha,
						'creador' => $this->creador,
						'qq_name' => $this->qq_name,
						'qq_descripcion' => $this->qq_descripcion,
						'token' => $this->token,
						'lapso' => $this->lapso,
						'timezone' => $this->launchingTZ
                    ]);
    }
}
