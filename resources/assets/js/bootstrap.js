window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('pagepiling.js');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
let locale = document.head.querySelector('meta[name="locale"]');

window.axios.defaults.baseURL = '/'+locale.content;

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.totalprize = 0;
window.events = new Vue();

window.flash = function (message, type = 'success') {
    window.events.$emit('flash', [message, type]);
};

window.shortenNum = function (number, abbrev = true) {
    number = parseFloat(number).toFixed(2);
    if (number < 1000) return number;
    let abbrevs = ['T', 'B', 'M', 'K', ''];
    let exponents = [12, 9, 6, 3, 0];

    for (exp of exponents) {
        if (number >= Math.pow(10, exp)) {
            let display_num = number / Math.pow(10, exp);
            let decimals = (exp >= 3 && Math.round(display_num) < 100) ? 1 : 0;

            if (!abbrevs) return display_num.toFixed(decimals);
            return display_num.toFixed(decimals) + abbrevs[exponents.indexOf(exp)];
        }
    }

    return number;
};