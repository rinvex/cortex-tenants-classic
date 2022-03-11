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

        (! app()->has('request.tenant') || ! app('request.tenant') || ! in_array($accessarea, ['managerarea', 'tenantarea'])) || $routeDomains = $routeDomains->map(fn ($routeDomain) => app('request.tenant')->slug.'.'.$routeDomain)->prepend(app('request.tenant')->domain);

        return $cachedDomains[$accessarea] = $routeDomains->toArray();
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
