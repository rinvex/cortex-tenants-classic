<?php

declare(strict_types=1);

namespace Cortex\Tenants\Providers;

use Illuminate\Routing\Router;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Cortex\Tenants\Http\Middleware\Tenantable;
use Cortex\Tenants\Console\Commands\SeedCommand;
use Cortex\Tenants\Console\Commands\InstallCommand;
use Cortex\Tenants\Console\Commands\MigrateCommand;
use Cortex\Tenants\Console\Commands\PublishCommand;
use Cortex\Tenants\Console\Commands\RollbackCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Middleware\SubstituteBindings;

class TenantsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        SeedCommand::class => 'command.cortex.tenants.seed',
        InstallCommand::class => 'command.cortex.tenants.install',
        MigrateCommand::class => 'command.cortex.tenants.migrate',
        PublishCommand::class => 'command.cortex.tenants.publish',
        RollbackCommand::class => 'command.cortex.tenants.rollback',
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
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'cortex.tenants');

        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.tenants.models.tenant'] === Tenant::class
        || $this->app->alias('rinvex.tenants.tenant', Tenant::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('tenant', '[a-zA-Z0-9-]+');
        $router->model('tenant', config('rinvex.tenants.models.tenant'));

        // Map relations
        Relation::morphMap([
            'tenant' => config('rinvex.tenants.models.tenant'),
        ]);

        // Load resources
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/managerarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/tenants');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/tenants');

        $this->app->runningInConsole() || $dispatcher->listen('accessarea.ready', function ($accessarea) {
            ! file_exists($menus = __DIR__."/../../routes/menus/{$accessarea}.php") || require $menus;
            ! file_exists($breadcrumbs = __DIR__."/../../routes/breadcrumbs/{$accessarea}.php") || require $breadcrumbs;
        });

        // Inject tenantable middleware
        // before route bindings substitution
        $this->app->booted(function () {
            $router = $this->app['router'];

            $pointer = array_search(SubstituteBindings::class, $router->middlewarePriority);
            $before = array_slice($router->middlewarePriority, 0, $pointer);
            $after = array_slice($router->middlewarePriority, $pointer);

            $router->middlewarePriority = array_merge($before, [Tenantable::class], $after);
            $router->pushMiddlewareToGroup('web', Tenantable::class);
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishesLang('cortex/tenants', true);
        ! $this->app->runningInConsole() || $this->publishesViews('cortex/tenants', true);
        ! $this->app->runningInConsole() || $this->publishesConfig('cortex/tenants', true);
        ! $this->app->runningInConsole() || $this->publishesMigrations('cortex/tenants', true);
    }
}
