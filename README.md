# Starter Admin Panel for Laravel projects
Build on AngularJS 1.5, Bootstrap 4

### Requirements

* Laravel 5.4

### Installation

* Install via composer
```sh
$ composer require mikelmi/mks-admin
```
* Add Mikelmi\MksAdmin\Providers\AdminServiceProvider::class to your providers config
* Publish assets and config
```sh
$ php artisan vendor:publish --provider="Mikelmi\MksAdmin\Providers\AdminServiceProvider"
```
* Edit config/admin.php

### Configure User
For accessing the admin panel User should have 'admin.access' ability (you can define it by `Gate::define()`).
See https://laravel.com/docs/master/authorization#gates for details

##### [Optional] Define SuperAdmin ability
Implement AdminableUserInterface by your User model

```php
// app/User.php
<?php
//...
use Mikelmi\MksAdmin\Contracts\AdminableUserInterface;

class User extends Authenticatable implements AdminableUserInterface {
    //...
    
    public function isSuperAdmin(): bool
    {
        //TODO: return true if user is SuperAdmin
        return false;
    }
}

```

##### [Optional] Enable Password Reset for admins
1. Enable it in `config/admin.php` file:

```php
<?php

return [
    //...
    'reset_enable' => true,
```

2. Add `Mikelmi\MksAdmin\Traits\AdminableUser` Trait to your User model

### Configure Menu
By default the menu items are built by `\Mikelmi\MksAdmin\Services\SimpleMenu` class and configured in the `config/admin.php`. E.g:
```php
'menu_manager' => \Mikelmi\MksAdmin\Services\SimpleMenu::class,
'menu' => [
    ['title'=>'Home', 'url'=>'#/home', 'hash'=>'home', 'icon'=>'home'],
    ['title'=>'Users', 'url'=>'#/users', 'hash'=>'users', 'icon'=>'user'],
],
```
But you can change the default menu manager class by your own which should implements `Mikelmi\MksAdmin\Contracts\MenuManagerContract`

### Controllers
1. Define admin routes in routes/admin.php
