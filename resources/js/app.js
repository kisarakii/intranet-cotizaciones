// Bootstrap (incluye Popper vía dependencia)
import 'bootstrap';

// Alpine.js (opcional para interacciones simples)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Módulos propios (si necesitas scripts extra para el offcanvas o UI)
import './modules/offcanvas';
