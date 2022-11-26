<?php

namespace App\Http\Livewire;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTime;
use DateTimeZone;
use DateInterval;
use Livewire\Component;
use App\Models\Publica;
use App\Models\Pregunta;
use App\Models\Participante;
//use App\Events\AplicaPregunta;
use App\Http\Livewire\ModalPregunta;
use App\Models\Opcion;
use App\Models\Respuesta;

class Play extends Component
{
	public $imagen = "/images/qq-play.svg";
	public Publica $publica;
	public $estado;
	public $indice;
	public $estado_inicial; // Emoticon
	//public $tiempo_refresco;	
	public Pregunta $pregunta;
	public Participante $participante;
	public $timezone; //Actualizado en la vista por función javascript
	public $lapso;
	public $crono_activo;
	public $bPreguntar;
	public Respuesta $respuesta;
	public $reintento;
	
	//Variables del modal
	public $tiempo;
	public $respuesta_smultiple;
	public $consecutivo;
	public $title;
	public $opciones;
	public Opcion $opcion;
	public $hint;
	public $siguiente;
	public $opcion_id;
	public $wins;
	public $losts;
	public $unanswered;
	public $promedio_aciertos;
	public $promedio_erros;
	public $mi_puesto;
	public DateTime $lanzada;
	public $tiempo_responder;
	public $efecto_ganar;
	public $efecto_perder;
	
	//protected $listeners = ['muestraPregunta' => 'muestraPregunta','captura_respuesta' =>'captura_respuesta', 'cerrar_pregunta' => 'cerrar_pregunta'];

	
	public function mount(Publica $publica, $participante_id)
	{
		$this->publica = $publica;
		$this->participante = Participante::find($participante_id);
		$this->estado_inicial = $this->participante->estado_inicial;		
		$this->estado = "Iniciando ....";
		$this->preguntas = $this->publica->encuesta->preguntas;
		$this->pregunta = $this->preguntas[0];
		$this->opciones = $this->preguntas->first->opciones->get();
		$this->tiempo = $this->pregunta->tiempo;
		$this->indice = -1;
		$this->siguiente = true;
		$this->tiempo_refresco = '500ms';
		$this->lapso = 0;
		$this->crono_activo = false;
		$this->reintento = false;
		$this->bPreguntar = true;
		if ($publica->xpregunta)
		{
			$this->indice = $this->publica->consecutivo;
		}
		$this->wins = "emoji_people ";
		$this->losts = "directions_walk ";
		$this->unanswered = "alarm_off ";
		$preguntas_lanzadas = json_decode($this->publica->preguntas_lanzadas);
		foreach ($preguntas_lanzadas as $pregunta_id)
		{
			$respuesta = Respuesta::where('participante_id',$this->participante->id)->where('pregunta_id',$pregunta_id)->first();
			if (!$respuesta)
			{
				$respuesta = New Respuesta;
				$respuesta->participante_id = $this->participante->id;
				$respuesta->pregunta_id = $pregunta_id;			
				//$respuesta->publica_id = $this->publica->id;
				$this->respuesta = $respuesta;
				$this->respuesta->save();
			}
		}
		$this->tiempo_responder = 0;
		$this->efecto_ganar = "";
		$this->efecto_perder = "";
		
	}
	public function inicia_cronometro()
	{
		if (!$this->crono_activo )
		{
			$comienza = $this->publica->launching->shiftTimezone($this->publica->launchingTZ);
			logger('Comienza cronometro a las: '.now()->format('h:i:s'));
			$this->crono_activo = true;
			$this->render();
		}
	}
	public function cerrar_pregunta()
	{
		
	}
	public function lee_pregunta_landaza_id()
	{
		$pregunta_id = $this->publica->pregunta_lanzada_id;
		$this->emit('log','Lee Pregunta lanzada'.$pregunta_id." ".$this->publica->pregunta_lanzada_id);
		if ($pregunta_id != $this->participante->ultimo_contestado)
			$this->muestraPregunta();
	}
	public function reintentar()
	{
		$this->bPreguntar = false;
		$this->mount($this->publica, $this->participante->id);
		$this->reintento = true;
		$this->muestraPregunta();
	}
	public function muestraPregunta()
	{
		//$this->efecto_ganar = "";
		//$this->efecto_perder = "";  
		$comienza = $this->publica->launching->shiftTimezone($this->publica->launchingTZ);
		$termina = $this->publica->landing->shiftTimezone($this->publica->launchingTZ);
		$this->preguntas = $this->publica->encuesta->preguntas;
		$date = new Carbon("now", new DateTimeZone($this->timezone) );
		if ($date < $comienza)
		{
			$this->estado = "SOON";
			$this->imagen = "/images/qq-wait.svg";
		}

		if ( $date->isBetween($comienza, $termina))
		{
			$this->estado = "ONAIR";
			$this->imagen = "/images/qq-play.svg";
			$this->lanzada = now();
			
				if ( $this->siguiente and $this->publica->pregunta_lanzada_id != null) 
				{
					if ($this->publica->pregunta_lanzada_id != $this->participante->ultimo_contestado)
					{	
						$this->indice++;
						$this->siguiente = false;						
						//$this->publica->consecutivo = $this->indice;
						$this->pregunta = Pregunta::find($this->publica->pregunta_lanzada_id);
						$this->emit('wait',$this->pregunta->tiempo, $this->indice);
						$this->tiempo = $this->pregunta->tiempo;
						$this->opciones = $this->pregunta->opciones;
					}
				}
			
		}

		if ($date > $termina)
		{
			$this->estado = "ENDED";
			$this->imagen = "/images/qq-sleep.svg";
		}
	}
	public function previo_captura_respuesta($valor_final=NULL)
	{
		$this->emitSelf('log','LLEGO A PREVIO'.now()->format('h:i:s'));
		$this->siguiente = true;
	}
	public function captura_respuesta($valor_final=NULL)
	{	
		$this->tiempo_responder = $this->lanzada->diffInSeconds(now());
		$this->emitSelf('cancela');
		$this->siguiente = true;
		if ($valor_final == "timeout")
		{
			$respuesta = Respuesta::where('participante_id',$this->participante->id)->where('pregunta_id',$this->pregunta->id)->first();
			if ($respuesta === null)
			{
				$this->respuesta = New Respuesta;
				$this->respuesta->participante_id = $this->participante->id;
				$this->respuesta->pregunta_id = $this->pregunta->id;			
				//$this->respuesta->publica_id = $this->publica->id;
				$this->respuesta->save();
				$this->respuesta->refresh();
			}
		}
		if ($this->opcion_id != null)
		{
			$this->emitSelf('log','Selecciono: '.$this->opcion_id);
			$respuesta = Respuesta::where('participante_id',$this->participante->id)->where('pregunta_id',$this->pregunta->id)->first();
			if ($respuesta != null)
				$this->respuesta = $respuesta;
			else
			{
				$this->respuesta = New Respuesta;
				$this->respuesta->participante_id = $this->participante->id;
				$this->respuesta->pregunta_id = $this->pregunta->id;			
				//$this->respuesta->publica_id = $this->publica->id;
			}

			$this->respuesta->opcion_id = $this->opcion_id;
			$this->respuesta_smultiple = Opcion::find($this->opcion_id)->text;
			$this->tiempo_responder = $this->lanzada->diffInSeconds(now());
			$this->respuesta->tiempo_responder = $this->tiempo_responder;
			$this->emitSelf('log',$this->respuesta_smultiple);	
			$this->participante->ultimo_contestado = $this->pregunta->id;

			//$this->publica->save();
			$this->participante->save();
			$this->respuesta->respuesta = $this->respuesta_smultiple;
			$this->respuesta->save();
			$this->participante->refresh();
			$this->respuesta->refresh();
			if ($this->respuesta->correcta())
			{
				$this->respuesta->puesto = Respuesta::where('pregunta_id',$this->respuesta->pregunta_id)->count() + 1;
				$this->efecto_ganar = " animate-[ping_1s_ease-in-out_1] ";
			}
			else {
				$this->efecto_perder = " animate-[ping_1s_ease-in-out_1] ";
			}
			$this->respuesta->save();
			$this->respuesta->refresh();
			$this->respuesta_smultiple = null;
			$this->opcion_id = null;

		} else
		{
			$this->hint = "Debe marcar una opción";
		}
		$total_participantes = $this->publica->participantes->count();
		/* if ($total_participantes > 0)
		{
			$this->promedio_aciertos = $this->publica->aciertos_totales()/$total_participantes;
			$this->promedio_erros = $this->publica->erros_totales()/$total_participantes;
			foreach ($this->publica->liderboard() as $key=>$concursante)
			{
				if ($concursante['id'] == $this->participante->id)
				{
						$this->mi_puesto = $key + 1;
						break;
				}
			}
		}
		*/
	}
	public function misrespuestas()
	{
		$this->bPreguntar = false;
		return  redirect()->route('misrespuestas',[
							'publica_id'=>$this->publica->id,
							'participante_id'=>$this->participante->id]);
	}
    public function render()
    {		
		return view('livewire.play');
    }
}
