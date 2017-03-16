<?php
/**
 * Author: mike
 * Date: 16.03.17
 * Time: 14:06
 */

namespace Mikelmi\MksAdmin\Services;


use Illuminate\Routing\Router;

class AdminRoute
{
    /**
     * @param string $controller
     * @param Router|null $router
     * @param bool $toggle
     * @param bool $move
     */
    public static function crud(string $controller, Router $router = null, $toggle = false, $move = false)
    {
        if (!$router) {
            $router = self::router();
        }

        $router->get('/', $controller . '@index')->name('index');
        $router->get('/edit/{model?}', $controller . '@edit')->name('edit');
        $router->post('/save/{model?}', $controller . '@save')->name('save');
        $router->post('/delete/{id?}', $controller . '@delete')->name('delete');

        if ($toggle) {
            $router->post('/toggle/{model?}', $controller . '@toggle')->name('toggle');
            $router->post('/toggle-batch/{status}', $controller . '@toggleBatch')->name('toggle.batch');
        }

        if ($move) {
            $router->post('move/{model?}/{down?}', $controller . 'UserController@move')->name('move');
        }
    }

    /**
     * @param string $controller
     * @param string $prefix
     * @param string|null $as
     * @param array $attributes
     * @param \Closure|null $routes
     */
    public static function group(string $controller, string $prefix, string $as = null, array $attributes = [], $routes = null)
    {
        $router = self::router();

        $toggle = array_pull($attributes, 'toggle', false);
        $move = array_pull($attributes, 'move', false);

        $attr = array_merge([
            'prefix' => $prefix,
            'as' => is_null($as) ? $prefix . '.' : $as
        ], $attributes);

        $router->group($attr, function($router) use ($controller, $toggle, $move, $routes) {
            static::crud($controller, $router, $toggle, $move);
            if ($routes instanceof \Closure) {
                $routes($router);
            }
        });
    }

    /**
     * @return \Illuminate\Routing\Router
     */
    protected static function router()
    {
        return app('router');
    }
}