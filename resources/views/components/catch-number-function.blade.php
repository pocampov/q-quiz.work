@props(['methodl','methodr','title' =>'?', 'id' => 'x', 'min' => 0, 'max' => 10, 'value' => $min])
<div class="w-fit">
	<div class="flex flex-row">
		<div wire:click='{{$methodl}}' class="text-4xl rounded-full bg-amber-200 hover:bg-amber-300 inline text-green-400 align-center w-fit">
			<div class="material-icons">
				arrow_back
			</div>
		</div>
		<div class="inline text-4xl" id='{{$id}}' value="{{$id}}" >{{$value}}</div>
		<div wire:click='{{$methodr}}' class="text-4xl rounded-full bg-amber-200 hover:bg-amber-300 inline text-green-400 align-center w-fit">
			<span class="material-icons">
				arrow_forward
			</span>
		</div>
	</div>
	<div class="text-sm text-center">
		{{$title}}
	</div>
</div>