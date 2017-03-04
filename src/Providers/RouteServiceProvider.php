<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 15:14
 */

namespace Mikelmi\MksAdmin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'App\Http\Controllers\Admin';

    public function map()
    {
        $routeFile = base_path('routes/admin.php');

        if (is_file($routeFile)) {
            Route::middleware(['web'])
                ->namespace($this->namespace)
                ->prefix(config('admin.url', 'admin'))
                ->as('admin::')
                ->group($routeFile);
        }
    }
}