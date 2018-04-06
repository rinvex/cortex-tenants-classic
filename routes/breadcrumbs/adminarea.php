<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.tenants.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tenants::common.tenants'), route('adminarea.tenants.index'));
});

Breadcrumbs::register('adminarea.tenants.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.tenants.import'));
});

Breadcrumbs::register('adminarea.tenants.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.import'), route('adminarea.tenants.import'));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.tenants.import.logs'));
});

Breadcrumbs::register('adminarea.tenants.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.create_tenant'), route('adminarea.tenants.create'));
});

Breadcrumbs::register('adminarea.tenants.edit', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push($tenant->name, route('adminarea.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.tenants.logs', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push($tenant->name, route('adminarea.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.tenants.logs', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.tenants.media.index', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push($tenant->name, route('adminarea.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('adminarea.tenants.media.index', ['tenant' => $tenant]));
});
