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
    'search_form' => false,
    'menu_manager' => \Mikelmi\MksAdmin\Contracts\MenuManagerContract::class,
    'menu' => [
        ['title'=>'Home', 'url'=>'#/home', 'hash'=>'home', 'icon'=>'home'],
    ],
    'scripts' => [],
    'appModules' => []
];
