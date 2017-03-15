<?php

return [
    'url' => env('ADMIN_URL', 'admin'),
    'site_url' => env('SITE_URL'),
    'username' => 'email',
    'reset_enable' => false,

    'locale' => 'en',
    'locales' => [
        'uk' => 'Українська',
        'en' => 'English'
    ],

    'menu_manager' => \Mikelmi\MksAdmin\Contracts\MenuManagerContract::class,
    'menu' => [
        ['title'=>'Home', 'url'=>'#/home', 'hash'=>'home', 'icon'=>'home'],
    ],

    'scripts' => [],
    'styles' => [],

    'appModules' => [],

    'factory' => [
        'classes' => [],
    ],

    'form' => [
        'buttons' => [],
        'layout' => 'row',
    ],

    'materialized' => false,
    'sidebar_inverse' => false,
];
