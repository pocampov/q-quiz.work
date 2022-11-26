<div class="container grid justify-items-stretch ">
	@if ($encuesta->preguntas->count() == 0)	
		<x-alert1
			creating=true
			icon='alert48.svg'
			title='Este QQ no tiene preguntas'
			text='Incluya preguntas antes de lanzarlo'
			boton1=''
			accion=''
			boton2='Entendido' 
		/>
	@else
		
	<div class="flex flex-col w-full sm:flex-row justify-center">
		<div class="sm:mt-4 text-lg ">
			<x-section >
				<x-slot name="header">
					<span class="material-icons inline">rocket</span> 
					LANZAMIENTO
				</x-slot>
				<x-slot name="image">
					
					<a href="/dashboard" class="hover:bg-green-100" title="Borrar">
						❎
					</a>
				</x-slot>
				<x-slot name="body">
					<div class="flex flex-col mt-4 mb-2">
						<div class="uppercase text-center font-semibold">
							{{ $encuesta->title }}
						</div>
						<div class="text-center" >
							{{ $encuesta->preguntas->count() }} Preguntas 
						</div>
					</div>
					<div class="flex flex-col m-2">
						<div class="flex justify-center">
							<label>
								<input wire:click="agendar" type="checkbox" name="grupo2" value="Todo" />
								<span class="text-xl">Agendar lanzamiento</span>
							</label>
						</div>		
						@if ($tipo == "Todo")
							<div class="flex justify-center">
								<div class="w-min text-center">
									<label for="date">Fecha:</label>
									<input wire:model="day" class="w-min" id="date" name="date" type="date" {{$apagar}} />
								</div>
							</div>
							<div class="flex justify-center">
								<div class="w-min text-center">
									<label for="time">Hora:</label>
									<input wire:model="time"  id="time" name="time" type="time" placeholder="h:m" value="{{date('h:i')}}" {{$apagar}} />
									<div class="text-sm">{{$timezone}}</div>
								</div>
							</div>
						@endif
						<div class="flex flex-row justify-center mt-2 align-middle">
							<label for="duracion" class="inline w-1/4 text-center self-center">
								Activo<br>Durante
							</label>
							<div class=" text-center w-1/4 m-0 p-0 inline ">
								<input wire:model="duracion" type="number" min={{$duracion_minima}} placeholder="minutos" id="duracion" class="text-center" />
							</div>
							<label for="duracion" class="inline w-1/4 text-center self-center">
								minutos
							</label>
							
						</div>
						<div class="flex justify-center mt-8">
							<x-jet-button wire:click="save" class="bg-red-500">
								{{ $label_boton }}
							</x-jet>
						</div>
					</div>
				</x-slot>
			</x-section>
		</div>
	@endif	
	
	<script>

		document.addEventListener('livewire:load', function () {	
			// guess user timezone 
				@this.timezone = moment.tz.guess();
				
			}
		)
    </script>

</div>