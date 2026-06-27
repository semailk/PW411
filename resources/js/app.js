import Alpine from 'alpinejs';

// Делаем Alpine доступным глобально
window.Alpine = Alpine;

// Инициализация
Alpine.start();

// Для дополнительных функций
document.addEventListener('DOMContentLoaded', function() {
    console.log('App initialized with Alpine.js');
});
