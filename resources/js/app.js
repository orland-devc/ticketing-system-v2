import axios from 'axios';
window.axios = axios;

// Optional: set a default base URL or headers
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css'; // same theme as your CDN

// Initialize highlighting on page load
document.addEventListener('DOMContentLoaded', () => {
    hljs.highlightAll();
});

// Optional: make hljs globally available (e.g., for dynamic content)
window.hljs = hljs;
