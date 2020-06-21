<?php

declare(strict_types=1);

return function () {
    // Discover and set current active tenant. We need `request.tenant` as early as we can, since
    // it's used in bootable traits, routes, and other resources called in service providers!
    $subdomain = mb_strstr($this->app->request->getHost(), '.'.domain(), true);
    $tenant = $subdomain ? app('rinvex.tenants.tenant')->where('slug', (string) $subdomain)->first() : null;
    $this->app->singleton('request.subdomain', fn () => $subdomain);
    $this->app->singleton('request.tenant', fn () => $tenant);
};
