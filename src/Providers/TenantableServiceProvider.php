<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Providers;

use Illuminate\Routing\Router;
use Cortex\Tenantable\Models\Tenant;
use Illuminate\Support\ServiceProvider;
use Rinvex\Tenantable\Contracts\TenantContract;
use Cortex\Tenantable\Http\Middleware\Tenantable;
use Cortex\Tenantable\Console\Commands\SeedCommand;
use Cortex\Tenantable\Console\Commands\InstallCommand;
use Cortex\Tenantable\Console\Commands\MigrateCommand;
use Cortex\Tenantable\Console\Commands\PublishCommand;

class TenantableServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.cortex.tenantable.migrate',
        PublishCommand::class => 'command.cortex.tenantable.publish',
        InstallCommand::class => 'command.cortex.tenantable.install',
        SeedCommand::class => 'command.cortex.tenantable.seed',
    ];

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
        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Bind route models and constrains
        $router->pattern('tenant', '[a-z0-9-]+');
        $router->model('tenant', TenantContract::class);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/tenantable');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/tenantable');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

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
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/tenantable')], 'cortex-tenantable-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/tenantable')], 'cortex-tenantable-views');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, function ($app) use ($key) {
                return new $key();
            });
        }

        $this->commands(array_values($this->commands));
    }
}
