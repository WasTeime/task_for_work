import './bootstrap.mjs';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Импортируем все необходимые модули здесь
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
