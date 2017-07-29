const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/assets/sass/main.sass', 'public/css')
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/admin/sass/myadmin.sass', 'public/admin')
    .js('resources/assets/admin/js/app.js', 'public/admin');
