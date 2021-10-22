<?php

declare(strict_types=1);

if (! function_exists('route_domains')) {
    /**
     * Return route domains array.
     *
     * @param string $accessarea
     *
     * @return array
     */
    function route_domains(string $accessarea): array
    {
        $routeDomains = collect(config('app.domains'))->filter(fn ($accessareas) => in_array($accessarea, $accessareas))->keys();

        (! app()->has('request.tenant') || ! app('request.tenant') || ! in_array($accessarea, ['managerarea', 'tenantarea'])) || $routeDomains = $routeDomains->map(fn ($routeDomain) => app('request.tenant')->slug.'.'.$routeDomain)->prepend(app('request.tenant')->domain);

        return $routeDomains->toArray();
    }
}

if (! function_exists('route_pattern')) {
    /**
     * Return route pattern.
     *
     * @param string $accessarea
     *
     * @return string
     */
    function route_pattern(string $accessarea): string
    {
        $routeDomainsPattern = implode('|', route_domains($accessarea));

        return "^({$routeDomainsPattern})$";
    }
}
