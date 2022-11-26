<div>
	<x-jet-modal wire:model="creating">
		<div role="alert">
			<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2 flex justify-center">
				<img src="/images/{{ $icon }}" />
			</div>
			<div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-2 py-3 text-red-700 content-center">
					<h4 class="text-center">{{$title}}</h4>
					<h5>{{ $text }}</h5>
				<div>	
					<x-jet-button wire:click="borrar({{ $parametro }})">{{ $boton1 }}</x-jet-button>
					<x-jet-button wire:click="$set('creating',false)">{{ $boton2 }}</x-jet-button>
				</div>
			</div>
		</div>
	</x-jet-modal>
</div>