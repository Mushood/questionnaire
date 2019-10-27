require('./bootstrap');

window.Vue = require('vue');

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import questionnaire from './components/questionnaire.vue';
Vue.component('questionnaire', questionnaire);

import build from './components/build.vue';
Vue.component('build', build);

import start from './components/start.vue';
Vue.component('start', start);

window.Event = new Vue();

const app = new Vue({
    el: '#app'
});
