<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		<style>
			a:hover {
				background-color: #16df4a;
			}
		</style>
	</head>
	<body>
		<div style="background-color:#f0f2f5;
					padding-top: 0.75rem; 
					padding-bottom: 0.75rem; ">

			<div style=" border: 4px solid #ffab00;  
						width: 80%; 
						margin:auto;  
						margin-bottom: 0.75rem;						
						border-radius: 0.75rem;
						background-color:#ffffff;">
				<div style="height: 10%;
							background-color:#dcfce7;
							border-top-left-radius: 0.5rem;
							border-top-right-radius: 0.5rem;
							text-align: center;
							font-weight: 700;
							color: #ffab00;
							font-size: 1.5rem;
							line-height: 2rem;
							align-self: center;">
					QUICK
					<img src="https://q-quiz.work/images/qq.png" width="10%" height="10%">
					QUIZ
				</div>
				<div style="padding: 0.75rem;
							margin-top: 0.75rem;">
					{{$nombre}}:<br>
					{{$creador}} te está invitando a participar en el QQ:<br>
					<div style="width: 60%; 
						margin:auto;  
						margin-bottom: 0.75rem;						
						border-radius: 0.75rem;
						background-color:#f0f2f5;
						border-radius: 0.75rem;
						padding: 0.75rem;
						box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
						">
						<div style="text-align: center;
									font-weight: 700;
									font-size: 0.75rem;">
							{{$qq_name}}
						</div>
						<div style="font-size: 0.6rem;
									text-align: center;">
							{{$qq_descripcion}}
						</div>
					</div>
					La prueba estará activa durante {{$lapso}} minutos,<br>
					el {{$fecha->locale('es')->dayName}} {{$fecha->day}}
					de {{$fecha->locale('es')->monthName}} desde las {{$fecha->format('g:i A')}} {{$timezone}}. <br>
					
					No faltes a la cita. Estará al aire {{$fecha->locale('es')->diffForHumans()}}, <br>
					Puedes entrar dando click en este token:  
					<a href="{{url('/participa/').'/'.$token}}"
					style ="
						font-size: 0.85rem;
						background-color:#16a34a;
						color: white;
						margin-top:0.2rem;
						padding: 0.5rem;
						padding-top: 0.2rem;
						padding-bottom: 0.2rem;
						border-radius: 0.5rem;
						">
						{{$token}}</a> 
				</div>
			</div>
		</div>
	</body>
</html>
