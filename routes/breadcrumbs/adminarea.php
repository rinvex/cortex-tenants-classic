<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::register('adminarea.cortex.tenants.tenants.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tenants::common.tenants'), route('adminarea.cortex.tenants.tenants.index'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.cortex.tenants.tenants.import'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.cortex.tenants.tenants.import'));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.cortex.tenants.tenants.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.create_tenant'), route('adminarea.cortex.tenants.tenants.create'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.edit', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.logs', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.cortex.tenants.tenants.logs', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.media.index', function (Generator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('adminarea.cortex.tenants.tenants.media.index', ['tenant' => $tenant]));
});
