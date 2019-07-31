import Vue from 'vue';
import axios from 'axios';
import App from './App.vue';

require('./bootstrap');

window.Vue = require('vue');

// Vue.use(axios);

// axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

Vue.component('app-component', App);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
