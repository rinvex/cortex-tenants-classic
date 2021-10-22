<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
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

            // Dynamically change session domain config on the fly
            if (array_key_exists($domain, config('app.domains'))) {
                config()->set('session.domain', '.'.$domain);
            } elseif (Str::endsWith($domain, array_keys(config('app.domains')))) {
                config()->set('session.domain', '.'.Arr::first(array_keys(config('app.domains')), fn ($tld) => Str::endsWith($domain, $tld)));
            }

            $session = config('session');
            Cookie::setDefaultPathAndDomain(
                $session['path'], $session['domain'], $session['secure'], $session['same_site'] ?? null
            );
        }

        return $next($request);
    }
}
