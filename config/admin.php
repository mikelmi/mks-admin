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
    'menu_manager' => Mikelmi\Admin\Services\Menu::class,
    'menu' => [
        ['title'=>'Home', 'url'=>'#/home', 'hash'=>'dashboard', 'icon'=>'home'],
    ],
    'scripts' => []
];
