<?php


namespace Mikelmi\MksAdmin\Providers;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mikelmi\MksAdmin\Contracts\AdminableUserInterface;
use Mikelmi\MksAdmin\Contracts\MenuManagerContract;
use Mikelmi\MksAdmin\Http\Middleware\AdminMiddleware;
use Mikelmi\MksAdmin\Http\Middleware\RedirectIfAuthenticated;
use Mikelmi\MksAdmin\Http\Middleware\SetAdminLocale;
use Mikelmi\MksAdmin\Http\ViewComposers\LayoutComposer;
use Mikelmi\MksAdmin\Http\ViewComposers\NavComposer;
use Mikelmi\MksAdmin\Services\Menu;

class AdminServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /** @var Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('admin', AdminMiddleware::class)
                ->aliasMiddleware('admin.guest', RedirectIfAuthenticated::class)
                ->aliasMiddleware('admin.locale', SetAdminLocale::class);

        $this->app->singleton(MenuManagerContract::class, function(Application $app) {
            $menuManager = $app['config']->get('admin.menu_manager', Menu::class);

            return new $menuManager($app['config']->get('admin.menu', []));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/admin.php' => config_path('admin.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/mikelmi/mks-admin'),
        ], 'public');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/../Http/routes.php';
        }

        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'admin');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin');

        view()->composer(
            'admin::_partials.sidebar', NavComposer::class
        );

        view()->composer(
            'admin::layout', LayoutComposer::class
        );

        Gate::before(function(Authenticatable $user, $ability) {
            if ($user instanceof AdminableUserInterface && $user->isSuperAdmin()) {
                return true;
            }

            return null;
        });
    }
}