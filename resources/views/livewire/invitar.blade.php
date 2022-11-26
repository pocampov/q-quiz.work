<div class="flex flex-col sm:flex-row">
	<div class="sm:w-3/6">
		<x-section2>	
			<x-slot name="header">
				LISTA INVITADOS
			</x-slot>
			<x-slot name="image" >
				<div class="text-center">📣</div>
				<div class="text-center text-lg" >
					TOKEN: 
					<div id="token" class="inline text-amber-600" >{{$publica->token}}</div>
					<button title="Copy to Clipboard" class="inline" onclick="copyToClipBoard()"><span id="symbol" class="material-icons text-sm font-semibold text-black">content_copy</span></button>
				</div>
			</x-slot>
			<x-slot name="inter">

			</x-slot>
			<x-slot name="body">
				<div class="mb-2 mx-4">
					<label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Invitado</label>
					<input wire:model="nombre" type="text" class=" placeholder-green-500 placeholder-opacity-50 text-center" placeholder="Nombre del invitado" />
				</div>
				<div class="mb-2 mx-4">
					<label for="mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Correo Electrónico</label>
					<input wire:model="mail" type="email" class=" placeholder-green-500 placeholder-opacity-50 text-center" placeholder="E-mail" />
				</div>
				<div class="flex justify-center">
					<x-button wire:click="agregar" class="mx-2">Agregar</x-button>
				</div>
				<hr class="my-2">
				<div class="flex justify-center bg-amber-50">
					<form wire:submit.prevent="upload_file" class="my-2">
						<input type="file" wire:model="listado"><br>
						<div class="animate-pulse flex space-x-4">
							<div wire:loading wire:target="listado" class="font-bold text-red-500">
								Uploading...
							</div>
						</div>
						@error('mail') <span class="error text-red-500">{{ $message }}<br></span> @enderror
						@error('nombre') <span class="error text-red-500">{{ $message }}</span> @enderror
						<div class="flex justify-center my-1">
							<x-button type="submit">Agregar Archivo</x-button>
						</div>
					</form>
				</div>
			</x-slot>
		</x-section2>
	</div>
	@if (count($invitaciones) != 0) 
		<div class="h-fit sm:w-3/6 mt-1 sm:mt-0 sm:ml-1">
			<x-section2>	
				<x-slot name="header">
					INVITACIONES
				</x-slot>
				<x-slot name="image" >
					<div class="text-center">✉</div>
				</x-slot>
				<x-slot name="inter">
					<div class="flex justify-center">
						<x-button wire:click="invitar" class="mx-2">Enviar</x-button>
						<x-button wire:click="salir" class="mx-2">Salir</x-button>
					</div>
				</x-slot>
				<x-slot name="body">
					@foreach ($invitaciones as $key=>$invitacion)
						<x-item2>
							<x-slot name="item">
								{{$invitacion['nombre']}}
							</x-slot>
							<x-slot name="item1">
								{{$invitacion['mail']}}						
							</x-slot>
							<x-slot name="item2">
								<div wire:click="borrar({{$key}})" class="focus-within:shadow-lg">
									{{$invitacion['estado']}}
								</div>
							</x-slot>
						</x-item>
					@endforeach
				</x-slot>
			</x-section2>
		</div>
	@endif
</div>