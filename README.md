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
