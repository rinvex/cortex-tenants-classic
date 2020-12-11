<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.cortex.tenants.tenants.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tenants::common.tenants'), route('adminarea.cortex.tenants.tenants.index'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.cortex.tenants.tenants.import'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.cortex.tenants.tenants.import'));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.cortex.tenants.tenants.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.create_tenant'), route('adminarea.cortex.tenants.tenants.create'));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.edit', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.logs', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.cortex.tenants.tenants.logs', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.cortex.tenants.tenants.media.index', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.cortex.tenants.tenants.index');
    $breadcrumbs->push(strip_tags($tenant->name), route('adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('adminarea.cortex.tenants.tenants.media.index', ['tenant' => $tenant]));
});
