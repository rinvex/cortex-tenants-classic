<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('adminarea.cortex.tenants.tenants.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.home');
    $breadcrumbs->push(trans('cortex/tenants::common.tenants'), route('adminarea.cortex.tenants.tenants.index'));
});

Breadcrumbs::for('adminarea.cortex.tenants.tenants.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.cortex.tenants.tenants.import'));
});

Breadcrumbs::for('adminarea.cortex.tenants.tenants.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.import');
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.cortex.tenants.tenants.import.logs'));
});

Breadcrumbs::for('adminarea.cortex.tenants.tenants.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.create_tenant'), route('adminarea.cortex.tenants.tenants.create'));
});

Breadcrumbs::for('adminarea.cortex.tenants.tenants.edit', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::for('adminarea.cortex.tenants.tenants.logs', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.edit', $tenant);
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.cortex.tenants.tenants.logs', ['tenant' => $tenant]));
});

Breadcrumbs::for('adminarea.cortex.tenants.tenants.media.index', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.edit', $tenant);
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('adminarea.cortex.tenants.tenants.media.index', ['tenant' => $tenant]));
});
