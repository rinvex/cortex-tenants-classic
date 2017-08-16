<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Providers;

use Illuminate\Routing\Router;
use Cortex\Tenantable\Models\Tenant;
use Illuminate\Support\ServiceProvider;
use Cortex\Tenantable\Http\Middleware\Tenantable;

class TenantableServiceProvider extends ServiceProvider
{
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/tenantable');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/tenantable');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();

        $router->pushMiddlewareToGroup('web', Tenantable::class);

        // Register attributable entities
        app('rinvex.attributable.entities')->push(Tenant::class);
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'migrations');
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/tenantable')], 'lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/tenantable')], 'views');
    }
}
