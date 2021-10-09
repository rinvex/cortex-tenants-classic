<?php

declare(strict_types=1);

if (! function_exists('route_domains')) {
    /**
     * Return route domains array.
     *
     * @return array
     */
    function route_domains(): array
    {
        $routeDomains = collect(config('app.domains'))->filter(fn ($accessareas) => in_array(request()->accessarea(), $accessareas))->keys();

        ! app('request.tenant') || $routeDomains = $routeDomains->map(fn ($routeDomain) => app('request.tenant')->slug.'.'.$routeDomain)->prepend(app('request.tenant')->domain);

        return $routeDomains->toArray();
    }
}

if (! function_exists('route_domains_pattern')) {
    /**
     * Return route domains pattern.
     *
     * @return string
     */
    function route_domains_pattern()
    {
        $routeDomainsPattern = implode('|', route_domains());

        return "^($routeDomainsPattern)$";
    }
}
