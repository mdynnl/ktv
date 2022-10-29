import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import flatpickr from 'flatpickr';

window.flatpickr = flatpickr;
window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(persist);
Alpine.start();
