import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;

Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize any flatpickr date inputs
    const dateInputs = document.querySelectorAll('[data-flatpickr]');
    dateInputs.forEach(input => {
        flatpickr(input, {
            dateFormat: 'Y-m-d',
        });
    });
});
