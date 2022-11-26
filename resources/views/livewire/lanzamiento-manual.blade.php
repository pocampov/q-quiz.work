<div x-data class="flex flex-col sm:flex-row">
	<div class="sm:w-3/6">
		<x-section2>	
			<x-slot name="header">
				LANZAMIENTO MANUAL<br>
				@foreach ($participantes as $i=>$participante)
					<div class="{{$textcolor[$i]}} m-0 p-0 inline-flex relative" title="{{$participante->nickname}}" >			
						<span class="material-icons m-0 p-0 inline relative {{$textcolor[$i]}}" style="letter-spacing: -1px;">
							{{$user_icon[$i]}}
						</span>
						<div class="inline-flex absolute -top-0 -right-1 justify-center items-center w-3 h-3 text-2xs font-bold text-red-100 bg-green-700 rounded-full border-0 border-white dark:border-gray-900">{{ $participante->aciertos() }}</div>
					</div>
				@endforeach
			</x-slot>
			<x-slot name="image" >
				<div class="text-center">⚡</div>
				<div class="text-center text-lg" >
					TOKEN: 
					<div id="token" class="inline text-amber-600" >{{$publica->token}}</div>
					<button title="Copy to Clipboard" class="inline" onclick="copyToClipBoard()"><span id="symbol" class="material-icons text-sm font-semibold text-black">content_copy</span></button>
				</div>
			</x-slot>
			<x-slot name="inter">
				
				<div wire:poll.keep-alive.{{$tiempo_refresco}}="actualiza_estado">
					{{-- <div class="w-full bg-gray-200 h-1">
						<div id="linea2" style="width:0%" title="Tiempo al aire" class="bg-red-600 h-1" ></div>
					</div> --}}
				</div> 	
			</x-slot>
			<x-slot name="body">
				@foreach ($preguntas as $key=>$pregunta)
					<x-item2>
						<x-slot name="item">
							<div class="w-full bg-gray-200 h-1">
								<div id="linea{{$key}}" style="width:0%" title="Tiempo al aire" class="bg-red-600 h-1" ></div>
							</div>
								<div class="font-bold">
								{{$key+1}}. {{$pregunta->enunciado}}
								</div>
							</x-slot>
							<x-slot name="item1">
								<div wire:click="minus({{$key}})" class="text-xl inline text-amber-400">
										◀
								</div>
								<div class="text-4xl inline" wire:model="tiempo.{{$key}}">
									{{$tiempo[$key]}}
								</div>
								<div wire:click="plus({{$key}})" class="text-xl inline text-amber-400"">
									▶
								</div >
								<div class="text-sm">
									segundos
								</div>
							</x-slot>
							<x-slot name="item2" >
								<div  @if ($desactivado=='') 
											x-on:click="
											@this.ignition(@js($key));
											crono1(@js($tiempo[$key]),@js($key));
											" 
											id="golf{{$key}}" title="Lanzar Pregunta" 
										@endif
										class="text-4xl {{$desactivado}}" >
									{{$ignition_image[$key]}}
								</div>
							</x-slot>
					</x-item2>
				@endforeach
			</x-slot>
		</x-section2>
	</div>
	<div class=" mt-1 sm:mt-0 sm:ml-1 sm:w-2/6">
		<x-section2 >
			<x-slot name="header">
				LIDERBOARD
			</x-slot>
			<x-slot name="image" >
				<span class="material-icons text-amber-600">
					format_list_numbered
				</span>
			</x-slot>
			<x-slot name="inter">
			</x-slot>
			<x-slot name="body">
				@if ($lider_board !== null)
					@foreach ($lider_board as $i=>$puesto)
						<x-item2>
							<x-slot name="item" >
								<div class="font-bold text-left flex">
									<div class="w-1/5 mx-1">
										{{$puesto['estado_inicial']}}
									</div>
									<div class="w-4/5">
										{{$i+1}}. {{$puesto['nickname']}}
									</div>
								</div>	
							</x-slot>
							<x-slot name="item1">
								<div class="text-base text-green-700 inline">
									{{$puesto['aciertos']}} 
								</div>
								<span class="material-icons  inline">check</span>
							</x-slot>
							<x-slot name="item2">
								<div class="text-base text-green-700 inline">
									{{$puesto['erros']}} 
								</div>
								<span class="material-icons text-red-600 inline">close</span>
							</x-slot>
						</x-item2>
					@endforeach
				@endif
			</x-slot>
		</x-section2>
	</div>
	<script>
		let transc = 0;	
		var process = 0;
		var contador = 1;


		function crono1(lapso,key) {
			if (process == 0) {
				key1 = key.toString();
				@this.actualiza_estado();
				document.getElementById("linea"+key1).style.width = 0;
				process = setInterval(function (){
					transc += 1;
					console.log('PING');
					document.getElementById("linea"+key1).style.width = ((transc / lapso )*100).toString()+"%"; 
					if (transc >= lapso){
						@this.actualiza_estado();
						@this.termina_pregunta();
						document.getElementById("linea"+key1).style.width = 0;
						transc = 0;
						console.log(contador+' Kill Proceso: '+process);
						clearInterval(process);
						process = 0;
					}
				}, 1000);
			console.log(contador+' Creando proceso: '+process);
			contador = contador + 1;
			}
		}
	</script>
</div>
