<?php

declare(strict_types=1);

namespace Cortex\Tenants\Providers;

use Illuminate\Routing\Router;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Support\ServiceProvider;
use Rinvex\Tenants\Contracts\TenantContract;
use Cortex\Tenants\Http\Middleware\Tenantable;
use Cortex\Tenants\Console\Commands\SeedCommand;
use Cortex\Tenants\Console\Commands\InstallCommand;
use Cortex\Tenants\Console\Commands\MigrateCommand;
use Cortex\Tenants\Console\Commands\PublishCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Middleware\SubstituteBindings;

class TenantsServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.cortex.tenants.migrate',
        PublishCommand::class => 'command.cortex.tenants.publish',
        InstallCommand::class => 'command.cortex.tenants.install',
        SeedCommand::class => 'command.cortex.tenants.seed',
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

        // Map relations
        Relation::morphMap([
            'tenant' => config('rinvex.tenants.models.tenant'),
        ]);

        // Load resources
        require __DIR__.'/../../routes/breadcrumbs.php';
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/tenants');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/tenants');
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->app->afterResolving('blade.compiler', function () {
            require __DIR__.'/../../routes/menus.php';
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();

        // Inject tenantable middleware before route bindings substitution
        $pointer = array_search(SubstituteBindings::class, $router->middlewarePriority);
        $before = array_slice($router->middlewarePriority, 0, $pointer);
        $after = array_slice($router->middlewarePriority, $pointer);

        $router->middlewarePriority = array_merge($before, [Tenantable::class], $after);
        $router->pushMiddlewareToGroup('web', Tenantable::class);

        // Register attributes entities
        app('rinvex.attributes.entities')->push(Tenant::class);
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../resources/lang') => resource_path('lang/vendor/cortex/tenants')], 'cortex-tenants-lang');
        $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views/vendor/cortex/tenants')], 'cortex-tenants-views');
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
