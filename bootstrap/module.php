<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('tenant', '[a-zA-Z0-9-_]+');
    Route::pattern('routeDomain', route_domains_pattern());
    Route::model('tenant', config('rinvex.tenants.models.tenant'));

    $centralDomains = route_domains();
    $domain = $this->app['request']->getHost();
    $scheme = $this->app['request']->getScheme();

    // Dynamically change session domain config on the fly
    if (in_array($domain, array_merge([optional($this->app['request.tenant'])->domain], $centralDomains))) {
        config()->set('session.domain', '.'.$domain);
        config()->set('app.url', $scheme.'://'.$domain);
    } elseif (Str::endsWith($domain, $centralDomains)) {
        $sessionDomain = Arr::first($centralDomains, fn ($tld) => Str::endsWith($domain, $tld));
        config()->set('session.domain', '.'.$sessionDomain);
        config()->set('app.url', $scheme.'://'.$domain);
    }
};
