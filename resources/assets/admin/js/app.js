window.Vue = require('vue');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
let locale = document.head.querySelector('meta[name="locale"]');

window.axios.defaults.baseURL = '/'+locale.content;

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.events = new Vue();

window.flash = function (message, type = 'alert-success') {
    window.events.$emit('flash', [message, type]);
};

Vue.component('settings', require('./components/settings/Settings.vue'));
Vue.component('create', require('./components/forms/Create.vue'));
Vue.component('new-ticket', require('./components/forms/NewTicket.vue'));
Vue.component('reply-to-ticket', require('./components/forms/ReplyToTicket.vue'));
Vue.component('my-table', require('./components/MyTable.vue'));
Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('tab', require('./components/Tab.vue'));
Vue.component('my-map', require('./components/Map.vue'));
Vue.component('flash', require('./components/Flash.vue'));

window.app = new Vue({
    el: '#app'
});