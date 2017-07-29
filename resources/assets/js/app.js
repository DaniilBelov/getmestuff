/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

require('./bootstrap');
require('./localisation');
require('parsleyjs');
require('./validation');
require('owl.carousel');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('tab', require('./components/Tab.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('errors', require('./components/Errors.vue'));
Vue.component('contact-form', require('./components/ContactForm.vue'));
Vue.component('login', require('./components/auth/Login.vue'));
Vue.component('register', require('./components/auth/Register.vue'));
Vue.component('website-header', require('./components/WebsiteHeader.vue'));
Vue.component('user-info', require('./components/user/Userinfo.vue'));
Vue.component('wishes', require('./components/wishes/Wishes.vue'));
Vue.component('user-page', require('./components/user/pages/Userpage.vue'));
Vue.component('payments', require('./components/user/Payments.vue'));
Vue.component('notifications', require('./components/user/Notifications.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('social-widgets', require('./components/SocialWidgets.vue'));

const app = new Vue({
    el: '#app'
});
