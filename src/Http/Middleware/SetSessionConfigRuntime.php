<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class SetSessionConfigRuntime
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->accessarea()) {
            $domain = $request->getHost();
            $scheme = $request->getScheme();

            config()->set('app.url', $scheme.'://'.$domain);

            // Dynamically change session domain config on the fly.
            // This method enforces session isolation between domains (including subdomains).
            // That means users who are signed in any subdomain or top level domain, will not be signed in other domains.
            if (array_key_exists($domain, config('app.domains')) || Str::endsWith($domain, array_keys(config('app.domains'))) || (app('request.tenant') && app('request.tenant')->domain === $domain)) {
                config()->set('session.domain', '.'.$domain);
            }
            // @TODO: we need add support for selective domain session sharing (with cross-domain cookie sharing as well)
            // The reason is for tenants who are using multiple domains like cortex.rinvex.test and cortex.test, once
            // their users signin any of their domains, they should be signed in all, and vice-versa with signout.

            $session = config('session');
            Cookie::setDefaultPathAndDomain(
                $session['path'],
                $session['domain'],
                $session['secure'],
                $session['same_site'] ?? null
            );
        }

        return $next($request);
    }
}
