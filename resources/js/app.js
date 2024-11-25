import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';

// Make Axios available globally
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();
