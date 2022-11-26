<div class="w-grow text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    <button type="button" class="relative inline-flex items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
        
        <div class="inline flex justify-between w-full">
			<div class="text-left w-3/4">
				{{ $item }}
			</div>
			@if ($encuesta_id != "")
				<div class="w-1/4 flex justify-between">
					<div class=" inline hover:scale-150 ">
						<a href="#" wire:click="confirma_borrar({{$encuesta_id}})" class="hover:bg-green-100 text-lg" title="Borrar">❎
						{{--<img src="/images/delete_forever24.svg" class="inline">--}}
						</a>
					</div>
					<div class=" inline hover:scale-150 ">
						<a href="#" wire:click="edita({{$encuesta_id}})" class="hover:bg-green-100 text-lg"title="Editar">✍
						{{--<img src="/images/visibility24.svg" class="inline">--}}</a>
					</div>
					<div class=" inline hover:scale-150 ">	
							<a href="/lanza/{{$encuesta_id}}" class="text-lg hover:bg-green-100" title="Lanzar">
							{{--<span class="material-icons inline">rocket</span>--}}🚀
							</a>
					</div>
				</div>	
			@endif
		</div>
    </button>
	{{-- @if ($muestra) --}}
		{{-- <livewire:edita-encuesta :id = "$encuesta->id"> --}}
	{{-- @endif --}}
</div>