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

mix.setResourceRoot('../');

const path = {
    assets: 'resources/assets',
    sass: 'resources/assets/sass',
    js: 'resources/assets/js',
    css: 'resources/assets/css',
    node: 'node_modules'
};

//css
mix.sass(path.sass + '/auth.scss', 'public/css');
mix.sass(path.sass + '/admin.scss', path.css);

mix.combine([
    path.css + '/admin.css',
    path.node + '/pace-js/themes/blue/pace-theme-flash.css'
], 'public/css/admin.css');


//materialized css
mix.sass(path.sass + '/auth-m.scss', 'public/css');
mix.sass(path.sass + '/admin-m.scss', path.css);

mix.combine([
    path.css + '/admin-m.css',
    path.node + '/pace-js/themes/blue/pace-theme-flash.css'
], 'public/css/admin-m.css');

//js
mix.js(path.js + '/auth.js', 'public/js');
mix.js(path.js + '/admin.js', 'public/js');

//font-awesome
mix.copy(path.node + '/font-awesome/fonts', 'public/fonts');

//copy images
mix.copy(path.assets + '/img', 'public/img');
