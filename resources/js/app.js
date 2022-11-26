require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Livewire.on('log', (mensaje) => {
	console.log(mensaje);
});

