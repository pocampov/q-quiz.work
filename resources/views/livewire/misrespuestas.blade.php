<div>
	<x-section>	
		<x-slot name="header">
			<div class="w-full">
				<div class="inline">
					MIS RESPUESTAS
				</div>
				<div class="w-48 text-sm text-center sm:inline">
					{{$participante->estado_inicial}}
					{{$participante->nickname}}
				</div>
			</div>
		</x-slot>
		<x-slot name="image" class="justify-center">
			<img src="{{ $imagen }}" />
		</x-slot>
		<x-slot name="body">
			@foreach ($preguntas as $pregunta)
				<x-item>
					<x-slot name="item" >
						<div class="flex justify-between">
							<div>
								<div class="font-bold">
									{{$pregunta->enunciado}}
								</div>
								<div class="font-light">
									{{ $participante->respuesta($publica->id,$pregunta->id) }}
								</div>
							</div>	
							<div class="font-light">
								<span class='material-icons text-green-600'>
									{{ $participante->correcta($publica->id,$pregunta->id) }}
								</span>
							</div>						
						</div>
					</x-slot>
					<x-slot name="encuesta_id" >
						
					</x-slot>
					<x-slot name="muestra" >
						---
					</x-slot>
				</x-item>
			@endforeach
			<x-jet-button wire:click.prevent="volver" class="text-base">
				👈 VOLVER
			</x-jet-button>			
		</x-slot>
	</x-section>
</div>
