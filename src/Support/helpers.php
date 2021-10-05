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
        $centralDomains = implode('|', central_domains());

        return "^(${centralDomains})$";
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
        $centralPattern = central_pattern();

        return "^((?!-|${centralPattern})[a-zA-Z0–9-]{1,63}(?<!-)\\.)+[a-zA-Z]{2,63}$";
    }
}
