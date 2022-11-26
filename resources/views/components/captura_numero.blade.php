@props(['title' =>'', 'id' => 'x', 'min' => 0, 'max' => 10, 'value' => $min])
<div class="w-fit">
	<div class="flex flex-row">
		<x-flecha_izquierda id='{{$id}}' min='{{$min}}'/>
		<div wire:model='{{$id}}' class="inline text-4xl" id='{{$id}}' value="{{$id}}" >{{$value}}</div>
		<x-flecha_derecha id='{{$id}}' max='{{$max}}'/>
	</div>
	<div class="text-sm text-center">
		{{$title}}
	</div>
</div>