<div x-data="{
	creating:false,
	}">

	
	  {{-- <div class="p-5 flex justify-end">
		<x-jet-button 
			x-on:click="creating=!creating">
			<template x-if="creating">
				<div>Hide</div>
			</template>
			<template x-if="!creating">
				<div>Create</div>
			</template>
		</x-jet-button>
	  </div> --}}
	  <div class="p-5">
	  {{-- <table :files="$files"/> --}} 
	</div>
	<div x-show="creating" x-cloak>
	{{-- <x-files.forma 
		trigger='creating'
	/> --}}
	</div>
</div>
