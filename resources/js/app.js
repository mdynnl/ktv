import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import flatpickr from 'flatpickr';

window.flatpickr = flatpickr;
window.Alpine = Alpine;

Alpine.plugin(persist);
Alpine.start();
