<div>
	<div class="mt-2 p-0 inline-flex relative" >
		<div class="material-icons m-0 p-0 inline relative text-{{$color}}-400 text-4xl">
			{{$icono}}
		</div>
		@if ($valor != "")
			<div class="absolute bottom-0 -right-1 items-center w-6 h-4 text-xs font-bold text-white rounded-full bg-opacity-70 bg-black ">
				{{ $valor }}
			</div>
		@endif	
	</div>
</div>