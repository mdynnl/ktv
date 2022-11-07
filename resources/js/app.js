// import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import flatpickr from 'flatpickr';


// Removed for now
// import * as echarts from 'echarts';
// window.echarts = echarts;
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(persist);
Alpine.start();
