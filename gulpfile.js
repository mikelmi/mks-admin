var elixir = require('laravel-elixir');

var path = {
    node: 'node_modules/',
    node_js: '../../../node_modules/'
};

elixir(function(mix) {

    //css
    mix.sass('auth.scss');
    mix.sass('admin.scss', 'resources/assets/css');

    mix.styles([
        'admin.css',
        path.node_js + 'pace-js/themes/blue/pace-theme-flash.css'
    ], 'public/css/admin.css');

    //materialized css
    mix.sass('auth-m.scss');

    mix.sass('admin-m.scss', 'resources/assets/css');
    mix.styles([
        'admin-m.css',
        path.node_js + 'pace-js/themes/blue/pace-theme-flash.css'
    ], 'public/css/admin-m.css');

    //auth js
    mix.scripts([
        path.node_js + 'jquery/dist/jquery.js',
        path.node_js + 'tether/dist/js/tether.js',
        path.node_js + 'bootstrap/dist/js/bootstrap.js',
        'general/*.js',
        'auth/*.js'
    ], 'public/js/auth.js');

    //admin js
    mix.scripts([
        path.node_js + 'jquery/dist/jquery.js',
        path.node_js + 'tether/dist/js/tether.js',
        path.node_js + 'bootstrap/dist/js/bootstrap.js',
        path.node_js + 'angular/angular.js',
        path.node_js + 'angular-sanitize/angular-sanitize.js',
        path.node_js + 'angular-cookies/angular-cookies.js',
        path.node_js + 'angular-route/angular-route.js',
        path.node_js + 'ng-toast/dist/ngToast.js',
        path.node_js + 'jquery-form/jquery.form.js',
        path.node_js + 'pace-js/pace.js',
        path.node_js + 'select2/dist/js/select2.js',
        'general/*.js',
        '*.js'
    ], 'public/js/admin.js');

    //font-awesome
    mix.copy([
        path.node + 'font-awesome/fonts'
    ], 'public/fonts');

    //copy images
    mix.copy([
        'resources/assets/img'
    ], 'public/img');
});