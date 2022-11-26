<div class="z-10">
	<x-tarjeta>
		<x-slot name="imagen" >
			/images/qq.svg
		</x-slot>
		<x-slot name="titulo">
			<img src="/images/TituloQQ.png" class="justify-self-center"/>
		</x-slot>
		<x-slot name="cuerpo">
			
			<div class="grid grid-cols-1 {{ $mitext_color }} shrink-0 text-center place-content-center ">
				{{ $resultado }} 
				<x-jet-input wire:model="token" type="text" class="bg-gray-300 border-solid border-2 text-center text-green-600 inline" placeholder="Token QQ">
				</x-jet-input>
				
				<x-jet-input wire:model="nickname" type="text" class="bg-gray-300 border-solid border-2 text-center text-green-600 my-4 inline" placeholder="mi nombre">
				</x-jet-input>
				 Cómo me siento?<br> 
				<div class="inline-flex text-green-600 place-content-center">
					
					<button wire:click.prevent='valida_token("🙁")' class="inline hover:scale-125 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-gray-300 disabled:opacity-25 text-2xl transition">
						🥺 
					</button>
					<button wire:click.prevent='valida_token("😨")' class="inline hover:scale-125 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-gray-300 disabled:opacity-25 text-2xl transition">
						😨 
					</button>
					<button wire:click.prevent='valida_token("😲")' class="inline hover:scale-125 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-gray-300 disabled:opacity-25 text-2xl transition">
						😲 
					</button>
					<button wire:click.prevent='valida_token("😉")' class="inline hover:scale-125 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-gray-300 disabled:opacity-25 text-2xl transition">
						😉 
					</button>
					<button wire:click.prevent='valida_token("😀")' class="inline hover:scale-125 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-gray-300 disabled:opacity-25 text-2xl ">
						😀
					</button>
				</div>
			</div>
		</x-slot> 
	</x-tarjeta>
	<style>
		body {
		font-family: 'Nunito', sans-serif;
		}
		/* Ojos moviendose */
		.move-area:after{/*normally use body*/
		  width: 5vw;
		  height: 5vh;
		  /* padding: 10% 45%; */
		}
		.container {
		  width: 100%;
		}
		.eyeD {
		  position: relative;
		  display: inline-block;
		  border-radius: 50%;
		  height: 40px;
		  width: 40px;
		  background: #CCC;
		}
		.eyeD:after { /*pupil*/
		  position: absolute;
		  bottom: 27px;
		  right: 20px;
		  width: 12px;
		  height: 12px;
		  background: #0A0;
		  border-radius: 50%;
		  content: " ";
		}
		.eyeI {
		  position: relative;
		  z-index:0;
		  display: inline-block;
		  border-radius: 50%;
		  height: 40px;
		  width: 40px;
		  background: #CCC;
		}
		.eyeI:after { /*pupil*/
		  position: absolute;
		  bottom: 27px;
		  right: 20px;
		  width: 12px;
		  height: 12px;
		  background: #0A0;
		  border-radius: 50%;
		  content: " ";
		}
		/* Fin de Ojos moviendose */
		/* Inicio animacion */
		/* The animation code */
		@keyframes rotando {
		  from {transform: rotate(0deg);}
		  to {transform: rotate(360deg);}
		}
		/* Inicio animacion */
		.load {
			  position: relative;
			  display: inline-block;
			  border-radius: 50%;
			  height: 40px;
			  width: 40px;
			  background-image: url("/images/espiral.png");
			  animation-name: rotando;
			  animation-duration: 1s;
			  animation-iteration-count: infinite;
		}
	</style>
	<script src="https://code.jquery.com/jquery-3.3.1.js">
	//JS para Ojos moviendose
		$("body").mousemove(function(event) {
		  var eye = $(".eyeD");
		  var x = (eye.offset().left) + (eye.width() / 2);
		  var y = (eye.offset().top) + (eye.height() / 2);
		  var rad = Math.atan2(event.pageX - x, event.pageY - y);
		  var rot = (rad * (180 / Math.PI) * -1) + 180;
		  eye.css({
			'-webkit-transform': 'rotate(' + rot + 'deg)',
			'-moz-transform': 'rotate(' + rot + 'deg)',
			'-ms-transform': 'rotate(' + rot + 'deg)',
			'transform': 'rotate(' + rot + 'deg)'
		  });
		  var eye1 = $(".eyeI");
		  var x1 = (eye1.offset().left) + (eye1.width() / 2);
		  var y1 = (eye1.offset().top) + (eye1.height() / 2);
		  var rad1 = Math.atan2(event.pageX - x1, event.pageY - y1);
		  var rot1 = (rad1 * (180 / Math.PI) * -1) + 180;
		  eye1.css({
			'-webkit-transform': 'rotate(' + rot1 + 'deg)',
			'-moz-transform': 'rotate(' + rot1 + 'deg)',
			'-ms-transform': 'rotate(' + rot1 + 'deg)',
			'transform': 'rotate(' + rot1 + 'deg)'
		  });
		});
	</script>
</div>