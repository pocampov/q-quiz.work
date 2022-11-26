<div class="w-full">
    <div class="conteiner m-0 border-4 border-amber-500 rounded-lg ">
		<header class="flex bg-green-100 justify-between rounded-lg inline">
			<div class="text-2xl my-2 px-2 ">
				{{ $header }}
			</div>
			<div class="text-2xl px-2 self-center place-items-end inline">
				{{ $image }}
			</div>
		</header>
				{{ $inter }}
		<section class="text-green-700 px-0 my-1 min-w-full md:h-96 resize-y overflow-auto">
			<div>
				{{ $body }}
			</div>
		</section>
	</div>
	
</div>
