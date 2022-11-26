<div x-data :class="$store.showq ">

	<x-tarjeta>
		<x-slot name="imagen">
			{{ $imagen }}
		</x-slot>
		<x-slot name="titulo">
			<h5 class="uppercase animate-[ping_1s_ease-in-out_1]">{{ $publica->encuesta->title }}</h5>

		</x-slot>
		<x-slot name="cuerpo">

{{-- ***************Inicio****************** --}}

	<div x-show="$store.showq" x-transition x-cloak >
		<div class="bg-amber-100 shadow-md shadow-amber-500/50">
		
			<h2 class="center py-0 space-x-4">
				<div class="inline"><i class="material-icons py-0">account_balance</i></div>
				<div class="text-lg self-center inline">
					<span id="seconds"></span>/{{$pregunta->tiempo}}
				</div>
			</h2>
			<h4 class="flow-text center py-0">
				{{$indice}}. {{$pregunta->enunciado}}
			</h4>
			<div class="flex place-content-center py-0 my-0">
				<form wire:submit.prevent="captura_respuesta">
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
	{{-- ********************************* --}}

			<div class="text-sm mt-4">{{ $publica->encuesta->description }}</div>

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
			@if ($estado == "SOON" )
				{{$comienza->format('m-d-y h:i:s')}}<br>
				<div class="font-bold text-xl mb-2 inline">
					{{$estado}} 
				</div>
				<div class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
					{{$timetostart}}
				</div>
				<div wire:poll.750ms="muestra_estado"></div>
			@else
				{{$estado}}
			@endif
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
					<button wire:click="misrespuestas" {{$mostrar_respuestas}} class='items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'>
						MIS RESPUESTAS
						@if ($mostrar_respuestas == "disabled")
							<div class="text-xs mt-2 text-center">	
								-{{$tiempo_mostrar_respuestas}}
							</div>
						@endif
					</button>
				</div>
			@if (!$publica->activo)
				<div class="text-xl text-amber-600">Este QQ está inactivo</div>
			@endif	
			
			{{-- Valor del indice: {{$indice}}--}}<br>
			Creado por: {{ $publica->encuesta->user->name }}
			- Token: {{ $publica->token }} {{ $estado_inicial }}
		</x-slot>
	</x-tarjeta>
	<div wire:init="muestra_estado"></div>
	<div wire:init="establece_final"></div>
	
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
			document.addEventListener('alpine:init', () => {
				Alpine.store('showq', false);
				Alpine.store('process', false);
				Alpine.store('seleccionVacia', true);
			})

			Livewire.on('get_timezone', () => {
				@this.timezone = moment.tz.guess();
			});
			Livewire.on('cancela', () => {
				clearInterval(process);
				process = 0;
			});
			Livewire.on('reloadToEnd', (seconds) => {
				setTimeout(@this.muestra_estado,seconds*1000);
			});			
			Livewire.on('startCountDown', (tiempo, pregunta) => {
				Alpine.store('showq',true);
				Alpine.store('seleccionVacia', true);
				if (process != 0)
					clearInterval(process);
				process = setInterval( function () {
					document.getElementById('seconds').innerHTML = tiempo;
					if ( tiempo > 0 )
					{
						if ( @this.indice == pregunta )
						{	
							tiempo = tiempo - 1;
							
						}
					} else
					{
						Alpine.store('showq', false);
						clearInterval(process);
						@this.captura_respuesta(false);
					}
				}, 1000
				);
				Alpine.store('process', process);
			})
			function cancela(){
				clearInterval(process);
				process = 0;
			}
		}
    </script>
	<script>

		
	</script>
</div>

