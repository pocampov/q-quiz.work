<div>
    <x-jet-modal wire:model="creating">
		<x-section>
		<x-slot name="header">
			PREGUNTA {{ $num_pregunta }}
		</x-slot>
		<x-slot name="image">
			<button wire:click.prevent="salir">
				<span class="material-icons">close</span>
			</button>
		</x-slot>
		<x-slot name="body" >
		QQ: {{ $encuesta->title }}
			<form>
				  <div class="mb-2">
					<label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >ENUNCIADO</label>
					<input wire:model='enunciado' type="text" class="placeholder-green-500 placeholder-opacity-50 text-center" placeholder="Has aqu&iacute; la pregunta" autofocus="autofocus" required />
					@error('enunciado')
						<span class="error">{{ $message }}</span> 
					@enderror
				  </div>
				  <div class="flex justify-between">
					  <div class="flex inline mx-1">
						<x-captura_numero id="num_opciones" title="OPCIONES" min="2" max="5" value="{{$num_opciones}}"/>
							{{-- <div class=" text-center w-1/2 m-0 p-0 inline ">
							<input id="opciones" wire:model="num_opciones" type="number" min="2" max="5" value="{{$num_opciones}}" class="inline text-center text-2xl font-bold" /> 
							<span class="inline text-sm">Opciones</span>
							</div> --}}
					  </div>
					  <div class="w-2/5 inline">
						<x-captura_numero id="tiempo" title="TIEMPO" min="10" max="180" value="{{$tiempo}}"/>
							{{-- <label for="descripcion" class="block text-sm font-medium text-gray-900 dark:text-gray-300 inline">TIEMPO: {{$tiempo}} segundos</label>
							<input wire:model="tiempo" type="number" class="placeholder-green-500 placeholder-opacity-50 text-center in-range:border-green-500 out-of-range:border-red-500 inline w-16" placeholder="Tiempo en segundos" value="11" min= "11"/> --}}
					  </div>
				  </div>
					<div class="flex content-center">
						<div class="w-5/6"></div>
						<div class="text-sm w-1/6">
							<div class="flex justify-center">
								Correcta
							</div>
						</div>
					</div>
					@for ($i = 0; $i < $num_opciones; $i++)
						<div class="flex justify-between">
							<div class="w-5/6">
								<input wire:model='opcion.{{$i}}' type="text" class="placeholder-green-500 placeholder-opacity-50 text-center  inline" placeholder="Opcion {{$i+1}}" />
							</div>
							<div class="w-1/6 flex items-center justify-center">
								<label class="text-center">
									<input wire:click="$set('correcta',{{$i}})" type="radio" name="group2" class="inline self-center py-0 my-0" />
									<span class="text-sm inline"></span>
								</label>
							</div>
						</div>	
					@endfor
				<div class="flex justify-center ">
					<div class= "pb-2 px-2">
						<x-jet-button wire:click="inserta(false)" class="text-base">GRABAR Y SALIR</x-jet-button>
					</div>
					<div class= "mb-2">
						<x-jet-button type="button" wire:click.prevent="inserta(true)" class="text-base">GRABAR Y CONTINUAR</x-jet-button>
					</div>
				</div>
			</form>
		</x-slot>
	</x-section>
	</x-jet-modal>
</div>
