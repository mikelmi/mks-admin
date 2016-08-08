<?php

Route::group(
    [
        'prefix' => config('admin.url', 'admin'),
        'namespace' => 'Mikelmi\MksAdmin\Http\Controllers',
        'middleware' => 'web'
    ],

    function (\Illuminate\Routing\Router $router) {
        
        //login/logout routes
        $router->get('login', ['as' => 'admin.login', 'uses' => 'Auth\AuthController@showLoginForm']);
        $router->post('login', ['as' => 'admin.login.post', 'uses' => 'Auth\AuthController@login']);
        $router->get('logout', ['as' => 'admin.logout', 'uses' => 'Auth\AuthController@logout']);

        // Password Reset Routes...
        if (config('admin.reset_enable')) {
            $router->get('password/reset/{token?}',
                ['as' => 'admin.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
            $router->post('password/email',
                ['as' => 'admin.reset.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
            $router->post('password/reset', ['as' => 'admin.reset.post', 'uses' => 'Auth\PasswordController@reset']);
        }

        $router->get('/', ['as' => 'admin', 'uses' => 'IndexController@index']);
        $router->get('/home', 'IndexController@home');
        $router->get('/menu', 'IndexController@menu');
    }
);