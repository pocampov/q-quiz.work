<div class="flex justify-center">
<div class="max-w-sm relative rounded overflow-hidden shadow-lg " style="text-align:center;">
    <div class="MyContainer relative">
        <img class="object-contain md:object-scale-down z-5" src="{{ $imagen }}" />
        <x-ojo />
	</div>
	
	
	<div class="px-6 py-4">
		<div class="grid font-bold text-xl mb-2 content-center">
			{{ $titulo }}
		</div>
		<p class="text-gray-700 text-base">
			{{ $cuerpo }}
		</p>
	</div>
</div>
</div>