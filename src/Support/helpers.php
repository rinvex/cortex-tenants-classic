<?php

declare(strict_types=1);

if (! function_exists('route_domains')) {
    /**
     * Return route domains array.
     *
     * @param string|null $accessarea
     *
     * @return array
     */
    function route_domains(string $accessarea = null): array
    {
        static $cachedDomains = null;

        if (isset($cachedDomains[$accessarea])) {
            return $cachedDomains[$accessarea];
        }

        $routeDomains = $accessarea ? collect(config('app.domains'))->filter(fn ($accessareas) => in_array($accessarea, $accessareas))->keys() : collect(config('app.domains'))->keys();

        if (app()->has('request.tenant') && app('request.tenant') && in_array($accessarea, ['managerarea', 'tenantarea'])) {
            $routeDomains = $routeDomains->map(fn ($routeDomain) => app('request.tenant')->slug.'.'.$routeDomain);

            if (! empty(app('request.tenant')->domain)) {
                $routeDomains->prepend(app('request.tenant')->domain);
            }
        }

        return $cachedDomains[$accessarea] = $routeDomains->toArray();
    }
}

if (! function_exists('default_route_domains')) {
    /**
     * Return default route domains array.
     *
     * @return array
     */
    function default_route_domains(): array
    {
        $routeDomains = [];

        app('accessareas')->each(function ($accessarea) use (&$routeDomains) {
            $routeDomains[$accessarea->slug] = get_str_contains(request()->getHost(), $routeDomain = route_domains($accessarea->slug)) ?: $routeDomain[0] ?? route_domains('frontarea')[0];
        });

        return $routeDomains;
    }
}

if (! function_exists('route_pattern')) {
    /**
     * Return route pattern.
     *
     * @param string|null $accessarea
     *
     * @return string
     */
    function route_pattern(string $accessarea = null): string
    {
        $routeDomainsPattern = implode('|', array_map('preg_quote', route_domains($accessarea)));

        return "^($routeDomainsPattern)$";
    }
}
