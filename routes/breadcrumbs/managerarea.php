<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('managerarea.cortex.tenants.tenants.edit', function (Generator $breadcrumbs) {
    $tenant = app('request.tenant');
    $breadcrumbs->parent('managerarea.home');
    $breadcrumbs->push(strip_tags($tenant->name), route('managerarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::for('managerarea.cortex.tenants.tenants.media.index', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('managerarea.cortex.tenants.tenants.edit', $tenant);
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('managerarea.cortex.tenants.tenants.media.index', ['tenant' => $tenant]));
});
