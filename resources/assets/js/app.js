require('./bootstrap');

window.Vue = require('vue');

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
