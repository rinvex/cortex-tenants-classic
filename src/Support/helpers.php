<?php

declare(strict_types=1);

if (! function_exists('central_pattern')) {
    /**
     * Return central domain patterns.
     *
     * @return string
     */
    function central_pattern()
    {
        $centralDomainPatterns = implode('|', central_domains());

        return "^($centralDomainPatterns)$";
    }
}

if (! function_exists('tenant_pattern')) {
    /**
     * Return tenant domain patterns.
     *
     * @return string
     */
    function tenant_pattern()
    {
        $cetralDomains = central_pattern();

        return "^((?!-|$cetralDomains)[a-zA-Z0–9-]{1,63}(?<!-)\.)+[a-zA-Z]{2,63}$";
    }
}
