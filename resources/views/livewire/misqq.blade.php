<div class="flex flex-col sm:flex-row">
	<div class="md:w-2/6 pr-1">
		<x-section class="w-2/6 ">
			<x-slot name="header">
				MIS QQ
			</x-slot>
			<x-slot name="image">
				🔰
			</x-slot>
			<x-slot name="body">
				@foreach ($encuestas as $encuesta)
					<x-item>
						<x-slot name="item" >
							<div wire:click="edita({{$encuesta->id}})"  >
								{{ $encuesta->title }}
							</div>
						</x-slot>
						<x-slot name="encuesta_id" >
							{{ $encuesta->id }}
						</x-slot>
						<x-slot name="muestra" >
							{{ $muestra }}
						</x-slot>
					</x-item>
				@endforeach
			</x-slot>
		</x-section>
	</div>
	<div class="sm:px-2 sm:pt-0 md:w-3/6 pt-1 ">
		<x-section>
			<x-slot name="header">
				CREA UN QQ
			</x-slot>
			<x-slot name="image">
			</x-slot>
			<x-slot name="body" >
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="list-unstyled">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif			
				<form wire:submit.prevent="submit">
					<div class="">
					  <div class="mb-6">
						<label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 ">TITULO</label>
						<input wire:model='title' type="text" class="placeholder-green-500 placeholder-opacity-50 text-center" placeholder="Ponle un titulo a tu QQ" required />
					  </div>
					  <div class="mb-2 ">
						<label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">DESCRIPCI&Oacute;N</label>
						<input wire:model="description" type="text" class=" placeholder-green-500 placeholder-opacity-50 text-center" placeholder="Cuenta en una frase qué vas a evaluar" />
					  </div>
					  <div class="mb-2">
						<label for="categoria" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">CATEGORIA</label>
						<input  wire:model="categoria" type="text" class="placeholder-green-500 placeholder-opacity-50 text-center" placeholder="Una palabra para clasificar" maxlength ="20" />
					  </div>
					 </div>
				  <div class="flex justify-between inline my-2">
						<label>
								<input wire:click="$set('pregunta_tipo', 'O')" class="inline py-0 my-0" name="group1" type="radio" value="O"  checked />
								<span class="text-xl">Opci&oacute;n Multiple</span>
						</label>
						<label >
								<input wire:click="$set('pregunta_tipo', 'A')" class="inline py-0 my-0" name="group1" type="radio" value="A"/>
								<span class="text-xl">Pregunta abierta</span>
						</label>
					</div>
					<div class= "flex justify-center">
						<x-jet-button type="submit" class="text-base">AGREGAR PREGUNTAS</x-jet-button>
					</div>
				</form>
				
				{{-- @if($mostrar_formulario)
					{{-- @livewire('inserta-pregunta', ['encuesta' => $nueva_encuesta, 'tipo'=>$pregunta_tipo]) 
					<livewire:inserta-pregunta :encuesta="$nueva_encuesta" :tipo="$pregunta_tipo">
				@endif --}}
			</x-slot>
		</x-section>
	</div>
	{{-- Datos para Alerta de borrado --}}
	<x-alert>
		<x-slot name="title">
			{{ $alert_title }}
		</x-slot>
		<x-slot name="text">
			{{ $alert_text }}
		</x-slot>
		<x-slot name="icon">
			{{ $alert_icon }}
		</x-slot>
		<x-slot name="boton1">
			{{ $alert_boton1 }}
		</x-slot>
		<x-slot name="boton2">
			{{ $alert_boton2 }}
		</x-slot>
		<x-slot name="accion1">
			{{ $alert_accion1 }}
		</x-slot>
		<x-slot name="parametro">
			{{ $alert_parametro }}
		</x-slot>
	</x-alert>
</div>
