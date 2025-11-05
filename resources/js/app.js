import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css';

document.addEventListener('DOMContentLoaded', () => {
    hljs.highlightAll();
});

window.hljs = hljs;
