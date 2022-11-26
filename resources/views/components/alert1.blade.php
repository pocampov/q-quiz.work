<div>
	<div class="jetstream-modal border border-4 border-amber-400 w-full h-full">
		<div role="alert">
			<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2 flex justify-center">
				<img src="/images/{{ $icon }}" />
			</div>
			<div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700 content-center">
					<h3 class="text-center">{{ $title }}</h3>
					<h5>{{ $text }}</h5>
				<div>
					<form action="/dashboard">
						@if ($boton1 != "")
							<x-jet-button wire:click="$accion">{{ $boton1 }}</x-jet-button>
						@endif
						<x-jet-button type="submit">{{ $boton2 }}</x-jet-button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>