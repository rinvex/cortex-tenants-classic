<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Middleware;

use Closure;

class Tenantable
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
        $subdomain = $request->route('subdomain');
        $tenant = app('rinvex.tenants.tenant')->where('slug', $subdomain)->first();

        if ($subdomain && $subdomain !== 'www' && ! $tenant) {
            return intend([
                'url' => route('frontarea.home'),
                'with' => ['warning' => trans('cortex/foundation::messages.resource_not_found', ['resource' => trans('cortex/tenants::common.tenant'), 'identifier' => $subdomain])],
            ]);
        }

        // Scope bouncer
        (! $tenant || ! app()->bound(\Silber\Bouncer\Bouncer::class)) || app(\Silber\Bouncer\Bouncer::class)->scope()->to($tenant->getKey());

        return $next($request);
    }
}
