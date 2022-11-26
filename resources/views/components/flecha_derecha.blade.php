@props(['id' => 'x', 'min' => 0, 'max' => 10])
<div onclick="
	valor_anterior = document.getElementById('{{$id}}').innerHTML;
	if (parseInt(valor_anterior) + 1 <= parseInt({{$max}}))
	{
		document.getElementById('{{$id}}').innerHTML = (parseInt(valor_anterior) + 1).toString();
		@this.{{$id}} = parseInt(document.getElementById('{{$id}}').innerHTML);
	}" 
	class="text-4xl rounded-full bg-amber-200 hover:bg-amber-300 inline text-green-400 align-center w-fit">
		<span class="material-icons">
			arrow_forward
		</span>
</div>