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
     * @param bool $trash
     * @param \Closure|null $routes
     */
    public static function crud(string $controller, Router $router = null, $toggle = false, $move = false, $trash = false, $routes = null)
    {
        if (!$router) {
            $router = self::router();
        }

        $router->get('/', $controller . '@index')->name('index');
        $router->get('/scope/{scope?}', $controller . '@index')->name('index');

        $router->get('/create', $controller . '@create')->name('create');
        $router->get('/show/{model}', $controller . '@show')->name('show');
        $router->get('/edit/{model}', $controller . '@edit')->name('edit');
        $router->post('/save/{model?}', $controller . '@save')->name('save');
        $router->post('/delete/{id?}', $controller . '@delete')->name('delete');

        if ($toggle) {
            $router->post('/toggle/{model?}', $controller . '@toggle')->name('toggle');
            $router->post('/toggle-batch/{status}', $controller . '@toggleBatch')->name('toggle.batch');
        }

        if ($move) {
            $router->post('move/{model?}/{down?}', $controller . 'UserController@move')->name('move');
        }

        if ($trash) {
            $router->post('/trash/{model?}', $controller . '@toTrash')->name('toTrash');
            $router->post('/restore/{model?}', $controller . '@restore')->name('restore');
        }

        if ($routes instanceof \Closure) {
            $routes($router);
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
        $trash = array_pull($attributes, 'trash', false);

        $attr = array_merge([
            'prefix' => $prefix,
            'as' => is_null($as) ? $prefix . '.' : $as
        ], $attributes);

        $router->group($attr, function($router) use ($controller, $toggle, $move, $trash, $routes) {
            static::crud($controller, $router, $toggle, $move, $trash, $routes);
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