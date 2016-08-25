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
            $router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.forgot');
            $router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.reset.email');
            $router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.reset');
            $router->post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.reset.post');
        }

        $router->get('/', ['as' => 'admin', 'uses' => 'IndexController@index']);
        $router->get('/home', 'IndexController@home');
        $router->get('/menu', 'IndexController@menu');
    }
);