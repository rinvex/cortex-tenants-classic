<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Cortex\Tenantable\Http\Middleware\Tenantable;

class TenantableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Load routes
        $this->loadRoutes($router);
        $router->pushMiddlewareToGroup('web', Tenantable::class);

        if ($this->app->runningInConsole()) {
            // Publish Resources
            $this->publishResources();
        }

        // Register a view file namespace
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/tenantable');

        // Load language phrases
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/tenantable');

        // Register sidebar menus
        $this->app->singleton('menus.sidebar.management', function ($app) {
            return collect();
        });

        // Register menu items
        $this->app['view']->composer('cortex/foundation::backend.partials.sidebar', function ($view) {
            app('menus.sidebar')->put('management', app('menus.sidebar.management'));
            app('menus.sidebar.management')->put('header', '<li class="header">'.trans('cortex/fort::navigation.headers.management').'</li>');
            app('menus.sidebar.management')->put('tenants', '<li '.(mb_strpos(request()->route()->getName(), 'backend.tenants.') === 0 ? 'class="active"' : '').'><a href="'.route('backend.tenants.index').'"><i class="fa fa-sitemap"></i> <span>'.trans('cortex/tenantable::navigation.menus.tenants').'</span></a></li>');
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Load the module routes.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function loadRoutes(Router $router)
    {
        // Load routes
        if ($this->app->routesAreCached()) {
            $this->app->booted(function () {
                require $this->app->getCachedRoutesPath();
            });
        } else {
            // Load Routes
            require __DIR__.'/../../routes/web.php';

            $this->app->booted(function () use ($router) {
                $router->getRoutes()->refreshNameLookups();
            });
        }
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        // Publish views
        $this->publishes([
            realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/tenantable'),
        ], 'views');

        // Publish language phrases
        $this->publishes([
            realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/tenantable'),
        ], 'lang');
    }
}
