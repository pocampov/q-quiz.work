<div>
	<x-tarjeta>
		<x-slot name="imagen">
			/images/qq.png
		</x-slot>
		<x-slot name="titulo">
		</x-slot>
		<x-slot name="cuerpo">
			<div class="grid shrink-0 text-center place-content-center">
				<img src="/images/TokenQQ.png">
				<x-jet-input type="text" class="bg-[#0e0] border-solid border-2 border-indigo-600 inline" />
				
				<div class="px-6 pt-4 pb-2">
					<x-jet-button class="inline-block bg-gray-800 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
						<span class="material-icons">
							play_arrow
						</span>
					</x-jet-button>
				</div>
			</div>
		</x-slot>
	</x-tarjeta>
</div>

