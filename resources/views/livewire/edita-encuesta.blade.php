<div>
    <x-jet-modal wire:model="creating">
	<div class="h-full">	
		<x-section>
			<x-slot name="header" >
				<input wire:model='encuesta.title' type="text" class="placeholder-green-500 placeholder-opacity-50 uppercase text-lg font-large text-center " placeholder="Titulo del QQ" autofocus="autofocus" required {{$edicion}}  />
				<div class="">
					<textarea wire:model='encuesta.description' class="placeholder-green-500 placeholder-opacity-50 h-auto text-lg font-lg text-center resize-none rounded-md" cols="65" rows="3" placeholder="Describa su QQ" required {{$edicion}}>
					</textarea>
				</div>
			</x-slot>
			<x-slot name="image" >
				<button wire:click.prevent="edicion">
					<span class="material-icons">edit</span>
				</button>
				<button wire:click.prevent="salir">
					<span class="material-icons">close</span>
				</button>	
			</x-slot>
			
			<x-slot name="body" >
			<form class="shadow-lg mb-2">
			{{-- @foreach ($preguntas as $key=>$pregunta) --}}
				@php 
					$pregunta = $preguntas[$key];
				@endphp
					PREGUNTA {{ $key + 1}}
					
						  <div class="mb-2 {{$fondo_input}}">
								<label for="enunciado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" >ENUNCIADO</label>
								<div class="{{$fondo_input}}">
									<input wire:model='enunciado.{{$key}}' type="text" class="placeholder-green-500 placeholder-opacity-50 text-lg font-large text-center " placeholder="Has aqu&iacute; la pregunta" autofocus="autofocus" required {{$edicion}} />
								</div>
						  </div>
						  <div class="flex justify-around">
							  <div >
								
								<x-catch-number-function  id="opciones_iniciales.$key" title="OPCIONES" min="2" max="5" value="{{$opciones_iniciales[$key]}}" methodl='methodl' methodr='methodr'/>
								
							  </div>
							  <div >
							  
								<x-catch-number-function  id="tiempo.$key" title="TIEMPO" min="10" max="360" value="{{$tiempo[$key]}}" methodl='methodtl' methodr='methodtr'/>
							  
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
							@for ($i = 0; $opciones_iniciales[$key]>$i; $i++)
								<div class="flex justify-between">
									
										<div class="w-5/6">
											<input wire:model='opcion.{{$key}}.{{0}}.{{$i}}' type="text" class="placeholder-green-500 placeholder-opacity-50 text-center  inline" placeholder="Opcion {{$i+1}}" {{$edicion}} />
										</div>	
									
									<div class="w-1/6 flex items-center justify-center">
										<label class="text-center" for="boton{{$key}}{{$i}}" />
											<div wire:loading >
												<div class="inline self-center py-0 my-0">
													<img src="/images/loader1.gif" width="40%" height="40%" class="inline self-center" />
												</div>	
											</div>
										
											<div wire:loading.remove> 
												<input 
												wire:click.prevent="correcta({{$key}},{{$i}})" 
												type="radio"  id="boton{{$key}}{{$i}}" name="group{{$key}}" class="inline self-center py-0 my-0" 
												@if ($correcta[$key]==$i)
													checked 
												@endif
												 {{ $edicion }}  />
												<span class="text-sm inline"></span>
											</div>
											
									</div>
								</div>	
							@endfor 
				<div class="flex justify-between mb-1">
					@if ($key > 0)
						<x-jet-button wire:click.prevent="$set('key',{{$key}}-1)" class="text-base">
							👈 ANTERIOR
						</x-jet-button>
					@else
						<div>
						</div>
					@endif	
					@if ($key < $preguntas->count() - 1)
						<x-jet-button wire:click.prevent="$set('key',{{$key}}+1)" class="text-base">
							SIGUIENTE 👉
						</x-jet-button>
					@endif
					@if ($key == $preguntas->count() - 1)
						<x-jet-button wire:click.prevent="nueva_pregunta" class="text-base">
							ADICIONAR ➕
						</x-jet-button>
					@endif
				</div>
				{{-- @endforeach --}}
						<div class="flex justify-center ">
							<div class= "pb-2 px-2">
								<x-jet-button wire:click.prevent="inserta(true)" class="text-base">
									GRABAR
								</x-jet-button>
							</div>
						</div>
					</form>
				
			</x-slot>
		</x-section>
	</div>	
	</x-jet-modal>
</div>