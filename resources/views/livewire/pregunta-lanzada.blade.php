<div class="flex flex-col sm:flex-row">
	<div class="md:w-2/6 pr-1">
		<x-section class="w-2/6 ">
			<x-slot name="header">
				PREGUNTA AL AIRE
			</x-slot>
			<x-slot name="image">
				<img src="/images/{{$icon}}" />
			</x-slot>
			<x-slot name="body">
				<div class="flex flex-col justify-center">
					<h3 class="text-center font-bold inline m-0">{{$reloj}}
					<span class="text-4xl align-middle inline">⏱</span></h3>
					
					<x-box class="{{$color_box}}">
						<div @if ($active) wire:poll.{{$periodo}}="temporizador" @endif >
							<span class="text-center text-sm">
								<div class="text-center text-lg" >
									Token: <div class="text-black inline w-8">
												<div id="token" class="inline" >{{$publica->token}}</div>
												<button  class="inline" wire:click="$emit('copyToClipBoard')"><span class="material-icons text-sm text-white">content_copy</span></button><br>
											</div>
									@if ($estado == -1)		
										SOON
									@elseif ($estado == -2)
										ENDED
									@else
										<blink>ON AIR</blink>
									@endif 
								</div>
								<div class="text-center">
									@if ($estado >= 0)
										{{$estado+1}}. {{$pregunta->enunciado}}<br>
									@endif
								</div>
								<div class="text-amber-300">
									Inicio: {{ $publica->launching." ".$publica->launchingTZ}}<br>
								</div>
							</span>
							@if ($estado >= 0)
								Pregunta ID: {{$publica->pregunta_lanzada_id}}<br>
								Tiempo: {{ $pregunta->tiempo }} segundos<br>
							@endif
						</div>
					</x-box>
				</div>
					@foreach ($participantes as $i=>$participante)
						<x-item>
							<x-slot name="item" >
								{{ $estado_inicial[$i] }} {{$participante->nickname}}
							</x-slot>
							<x-slot name="encuesta_id" >
								
							</x-slot>
							<x-slot name="muestra" >
								A&&B
							</x-slot>
						</x-item>
					@endforeach
			</x-slot>
		</x-section>
	</div>
	<script>
	    document.addEventListener('livewire:load', function () {
            // Your JS here.
			window.Livewire.on('copyToClipBoard', ()=>{
				const range = document.createRange();
				range.selectNode(document.getElementById("token"));
				window.getSelection().removeAllRanges();
				window.getSelection().addRange(range);
				document.execCommand("copy");
				window.getSelection().removeAllRanges();
			})
        })
	</script>
</div>