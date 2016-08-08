var elixir = require('laravel-elixir');

var path = {
    node: 'node_modules/',
    node_css: '../../../node_modules/',
    node_js: '../../../node_modules/'
};

elixir(function(mix) {

    //css
    mix.sass('admin.scss');
    mix.sass('auth.scss');

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