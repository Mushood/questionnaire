require('./bootstrap');

window.Vue = require('vue');

import questionnaire from './components/questionnaire.vue';
Vue.component('questionnaire', questionnaire);

window.Event = new Vue();

const app = new Vue({
    el: '#app'
});
