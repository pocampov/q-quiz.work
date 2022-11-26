<div>

    <x-jet-modal wire:model="creating">
		<h2 class="center py-0 space-x-4">
			<div class="inline"><i class="material-icons py-0">account_balance</i></div>
			<div @if ($tiempo>0) wire:poll.500ms="testeo" @endif 
				class="text-lg self-center inline">
				{{ date("i:s",$tiempo) }} 
			</div>
		</h2>
		<h4 class="flow-text center py-0">
			{{$consecutivo}}. {{$title}}
		</h4>
		<div class="flex place-content-center py-0 my-0">
			<form action="#">
			<table class="highlight flex items-center py-0 my-0" >
					@foreach ($opciones as $opcion)
					<tr class="center py-0 my-0" style="line-height: 14px;">
						<td class="py-0 my-0"> 
						<label >
							<input wire:model="respuesta_smultiple" class="inline py-0 my-0" name="group1" type="radio" value={{$opcion['id']}}/>
							<span class="text-xl">{{ $opcion['text'] }}</span>
						</label>	
						</td>
					</tr> 
					@endforeach
					<tr><td>
							<h6 class="flow-text center py-0 my-0">
								<p class="text-xl">{{ $hint }}</p>
							</h6>
							<x-jet-button wire:click.prevent="captura_respuesta" class="bg-green-700 hover:bg-green-500 mb-4">
									ENVIAR
							</x-jet-button>
							</td></tr>
				</table>
			</form>
		</div>
	</x-jet-modal>
</div>
