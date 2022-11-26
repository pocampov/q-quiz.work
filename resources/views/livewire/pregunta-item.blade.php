<div>
	<ul class="collection with-header">
			<li class="collection-header green-text text-darken-3 center"><h4>
				{{ $pregunta->enunciado }}</h4>
			</li>
			@foreach ($opciones as $opcion)
				<li class="collection-item">
					<div>
						{{ $opcion['text'] }}
					</div>
				</li>
			@endforeach
			<li class="collection-item" >
				<div class="flex justify-center" wire:model="boton">
					<x-jet-button class="bg-green-{{$brillo_boton}} hover:bg-green-500" wire:click="activaPregunta({{ $pregunta['id'] }})">
						{{ $label_boton }}
					</x-jet-button>
				</div>
			</li>
	</ul>
</div>
