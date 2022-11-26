<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="icon" href="{{ asset('images/favicon.ico') }}">
        <title>QUICK-QUIZ</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Script -->
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="{{ mix('js/app.js') }}" defer></script> 
		<!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			
		@livewireStyles
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
			/* Material Icons
			.material-icons {
			  font-family: 'Material Icons';
			  font-weight: normal;
			  font-style: normal;
			  font-size: 24px;  /* Preferred icon size */
			  display: inline-block;
			  line-height: 1;
			  text-transform: none;
			  letter-spacing: normal;
			  word-wrap: normal;
			  white-space: nowrap;
			  direction: ltr;

			  /* Support for all WebKit browsers. */
			  -webkit-font-smoothing: antialiased;
			  /* Support for Safari and Chrome. */
			  text-rendering: optimizeLegibility;

			  /* Support for Firefox. */
			  -moz-osx-font-smoothing: grayscale;

			  /* Support for IE. */
			  font-feature-settings: 'liga';
			}
		
			.material-symbols-outlined {
			  font-variation-settings:
			  'FILL' 0,
			  'wght' 400,
			  'GRAD' 0,
			  'opsz' 48
			}
			/* Fin Material Icons */
			/* clases propias */
			.MyContainer div {
                
            }
			/* Fin clases propias
        </style>

    </head>
    <body class="antialiased">
		
		<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"> 
		        
    			@if (Route::has('login'))
                    <div class="top-0 right-0 px-6 py-4 sm:block">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                        @else
                        <div>
                            <x-jet-responsive-nav-link href="{{ route('login') }}" >
                                {{ __('Login') }}
                            </x-jet-responsive-nav-link> 
                            <x-jet-responsive-nav-link href="{{ route('register') }}" >
                                {{ __('Register') }}
                            </x-jet-responsive-nav-link>
    					</div>
                        @endauth
                    </div>
    			@endif
    			
				<div class="container">
					<livewire:participa />	
				</div>
			</div>
		@stack('modals')
		
   		<script>
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

		@livewireScripts
	</body>
</html>
