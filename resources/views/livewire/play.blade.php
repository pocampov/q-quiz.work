<div  x-data="{}">
	<x-tarjeta>	
		<x-slot name="imagen">
			{{ $imagen }}
		</x-slot>
		<x-slot name="titulo">
			<h5 class="uppercase animate-[ping_1s_ease-in-out_1]">{{ $publica->encuesta->title }}</h5>
		</x-slot>
		<x-slot name="cuerpo">
			@if ($estado != "ENDED")
				<div wire:poll.1000ms="lee_pregunta_landaza_id">
				</div>
			@endif
			
		{{-- ***************Inicio Pregunta****************** --}}
			<div x-show="$store.showq" x-transition x-cloak >
				<div class="bg-amber-100 shadow-md shadow-amber-500/50">
					<h2 class="center py-0 space-x-4">
						<div class="inline"><i class="material-icons py-0">account_balance</i></div>
						<div class="text-lg self-center inline">
							<span id="seconds" x-text="$store.crono"></span> / {{$pregunta->tiempo}}
						</div>
					</h2>
					<h4 class="flow-text center py-0">
						{{$indice}}. {{$pregunta->enunciado}}
					</h4>
					<div class="flex place-content-center py-0 my-0">
						<form wire:submit.prevent="captura_respuesta(true)">
							@csrf
							<table class="highlight flex items-center py-0 my-0" >
								@foreach ($opciones as $opcion)
								<tr class="center py-0 my-0" style="line-height: 14px;">
									<td class="py-0 my-0"> 
									<label >
										<input wire:click="$set('opcion_id',{{$opcion->id}})"  x-on:click="Alpine.store('seleccionVacia', false);" class="inline py-0 my-0" name="group1" type="radio" value="{{$opcion->id}}" required />
										<span class="text-xl">{{ $opcion['text'] }}</span>
									</label>
									</td>
								</tr> 
								@endforeach
								<tr><td>
									<div x-on:click="if (!Alpine.store('seleccionVacia')) {
										Alpine.store('showq',false);
										clearInterval(Alpine.store('process'));}" >
										<x-button type="submit"
										class="bg-green-700 hover:bg-green-500 mb-4 " >
											ENVIAR
										</x-button>
									</div>	
										</td></tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		{{-- *************FIN PREGUNTA******************** --}}

			<div class="text-sm">{{ $publica->encuesta->description }}</div>

			<div class="shadow shadow-amber-500/40 w-full h-12 m-2 flex justify-around">
				<div class="text-sm self-center w-32">
					{{$estado_inicial}}{{$participante->nickname}}
					<div class="self-center" title="Tiempo en responder">
					⏳{{$tiempo_responder}}s.
					</div>
				</div>
				<div title="Aciertos" class="{{$efecto_ganar}}">
					<x-insignia>
						<x-slot name="icono">
							{{$wins}}
						</x-slot>
						<x-slot name="color">
							green
						</x-slot>
						<x-slot name="valor">
							{{$participante->aciertos()}}
						</x-slot>
					</x-insignia>
				</div>
				<div title="Sin responder">
					<x-insignia>
						<x-slot name="icono">
							{{$unanswered}}
						</x-slot>
						<x-slot name="color">
							amber
						</x-slot>
						<x-slot name="valor">
							{{$participante->sincontestar()}}
						</x-slot>
					</x-insignia>
				</div>
				<div title="Incorrectas" class="{{$efecto_perder}}">
					<x-insignia>
						<x-slot name="icono">
							{{$losts}} 
						</x-slot>
						<x-slot name="color">
							red
						</x-slot>
						<x-slot name="valor">
							{{$participante->erros()}}
						</x-slot>
					</x-insignia>
				</div>
			</div>
			<div class="shadow shadow-amber-500/40 w-full h-12 m-2 flex justify-around">
				<div class="text-sm self-center w-16">
					PROMEDIO GRUPO
				</div>
				<div title="Aciertos">
					<x-insignia>
						<x-slot name="icono" >
							people_alt 
						</x-slot>
						<x-slot name="color">
							green
						</x-slot>
						<x-slot name="valor">
							{{$promedio_aciertos}}
						</x-slot>
					</x-insignia>
				</div>
				<div title="Incorrectas">
					<x-insignia>
						<x-slot name="icono">
							group_off
						</x-slot>
						<x-slot name="color">
							red
						</x-slot>
						<x-slot name="valor">
							{{$promedio_erros}}
						</x-slot>
					</x-insignia>
				</div>
			</div>
			<div class="shadow shadow-amber-500/40 w-full h-12 m-2 flex justify-around">
				<div class="text-sm  self-center">
					PUESTO  
				</div>
				<div class="grid grid-cols-2 gap-4 place-content-center">
					<x-insignia >
						<x-slot name="icono">
							<div class="text-3xl place-self-center">
								@if ($mi_puesto < 4)
									🏆
								@elseif ($mi_puesto < 11)
									🎖
								@else
									🚩
								@endif
							</div>
						</x-slot>
						<x-slot name="color">
							green
						</x-slot>
						@if ($mi_puesto)
						<x-slot name="valor">
							{{$mi_puesto}}
						</x-slot>
						@else
							<x-slot name="valor">
							</x-slot>
						@endif
					</x-insignia>
				</div>
			</div>
			<div class="font-bold">
				{{$publica->encuesta->preguntas->count()}} Preguntas<br>
			</div>
			{{$estado}} 
			<span id="lapso"></span><br>
			@if ($estado == "ONAIR")
				@if (!$publica->xpregunta)
					Programado para {{ $publica->launching->format('d-M-y h:i:s')}}
					<br><x-button wire:click="reintentar" >RE-INTENTAR</x-button>
					<div class="text-xs">
						Sólo cambiarán las preguntas que conteste
					</div>
				@endif
			@endif
			<div class="text-xl text-amber-600">
				<x-button wire:click="misrespuestas" >MIS RESPUESTAS</x-button>
			</div>			
			@if (!$publica->activo)
				<div class="text-xl text-amber-600">Este QQ está inactivo</div>
			@endif	
			
			{{-- Valor del indice: {{$indice}}--}}<br>
			Creado por: {{ $publica->encuesta->user->name }}
			- Token: {{ $publica->token }} {{ $estado_inicial }}
		</x-slot>
	</x-tarjeta>
	<div wire:init="inicia_cronometro"></div>
	
	

	<script>
		document.addEventListener('livewire:load', function () {	
			// guess user timezone 
				@this.timezone = moment.tz.guess();
			}
		)
    </script>
	<script>
		window.onload = function () {
			var process = 0;
			var bPreguntar = true;
			var contador = 1;
			document.addEventListener('alpine:init', () => {
				Alpine.store('showq', false);
				Alpine.store('crono', 0);
				Alpine.store('seleccionVacia', true);
			})
			Livewire.emit('muestraPregunta');
			Livewire.on('wait', (valor,pregunta) => {
				Alpine.store('showq',true);
				countDown(valor, pregunta);
			});
			Livewire.on('cancela', () => {
				console.log(contador+' Kill proceso: '+process);
				clearTimeout(process);
			});

			Livewire.on('log', (mensaje) => {
				console.log('OPCION_ID: '+mensaje);
			});
			
			function countDown(tiempo, pregunta) {
				Alpine.store('seleccionVacia', true);
				process = setInterval(
					function () {
						
						if ( tiempo > 0 )
						{
							tiempo = tiempo - 1;
							document.getElementById('seconds').innerHTML = tiempo;
							Alpine.store('crono',tiempo);
						}else
						{
							//@this.showq = false;
							//@this.creating = false;
							console.log('Se acabó el tiempo');
							Alpine.store('showq',false);
							@this.captura_respuesta('timeout');
							console.log(contador+' Kill proceso: '+process);
							clearInterval(process);
						}
					}, 1000
				);
				console.log(contador+' Se crea proceso: '+process);
				contador++;
			}
		}
	</script>
</div>
