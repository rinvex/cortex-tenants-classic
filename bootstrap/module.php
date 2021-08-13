<?php

declare(strict_types=1);

use Cortex\Tenants\Http\Middleware\Tenantable;
use Illuminate\Routing\Middleware\SubstituteBindings;

return function () {
    // Bind route models and constrains
    Route::pattern('tenant', '[a-zA-Z0-9-_]+');
    Route::model('tenant', config('rinvex.tenants.models.tenant'));

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

    // Discover and set current active tenant. We need `request.tenant` as early as we can, since
    // it's used in bootable traits, routes, and other resources called in service providers!
    $subdomain = mb_strstr($this->app->request->getHost(), '.'.domain(), true);
    $tenant = $subdomain ? app('rinvex.tenants.tenant')->where('slug', (string) $subdomain)->where('is_active', true)->first() : null;
    $this->app->singleton('request.subdomain', fn () => $subdomain);
    $this->app->singleton('request.tenant', fn () => $tenant);
};
