<div>
	<div class="row flex place-content-center">
		<div class=" mx-28 md:mt-8 sm:mt-4">
		  <div class="card amber accent-4">
			<div class="card-content white-text">
			  <span class="card-title"><b>Encuesta: </b>{{ $encuesta_id }}</span>
			  <span class=""><b>Token: </b>{{ $publica->token }}</span>
			  <p><b>Titulo: </b>{{ $titulo }}</p>
			</div>
			<div class="card-action">
				@foreach ($preguntas as $pregunta)
					<livewire:pregunta-item :pregunta_id="$pregunta['id']"> 
				@endforeach
			</div>
		  </div>
		</div>
	</div>
	
</div>
