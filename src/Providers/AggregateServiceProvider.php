<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Providers;

use Illuminate\Support\AggregateServiceProvider as BaseAggregateServiceProvider;
use Rinvex\Tenantable\TenantableServiceProvider as BaseTenantableServiceProvider;

class AggregateServiceProvider extends BaseAggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        BaseTenantableServiceProvider::class,
        TenantableServiceProvider::class,
    ];
}
