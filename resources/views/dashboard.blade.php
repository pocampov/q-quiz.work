@auth
	<x-app-layout>
	
		<x-slot name="header">
			<h6 class="font-semibold text-lg text-gray-800 leading-tight py-0 my-0">
				{{ __('Dashboard') }}
			</h6>
		</x-slot>

		<div class="py-2">
			<div class="max-w-7xl mx-auto sm:px-1 lg:px-4">
				<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
					{{-- <livewire:preguntas /> --}}
					<livewire:misqq />
				</div>
			</div>
		</div>
	</x-app-layout>
@endauth
@guest
	<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
	    @livewire('navigation-menu')
		{{-- <welcome /> --}}
	</div>
@endguest