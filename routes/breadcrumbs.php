<?php

declare(strict_types=1);

use Rinvex\Tenants\Models\Tenant;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.tenants.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/tenants::common.tenants'), route('adminarea.tenants.index'));
});

Breadcrumbs::register('adminarea.tenants.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push(trans('cortex/tenants::common.create_tenant'), route('adminarea.tenants.create'));
});

Breadcrumbs::register('adminarea.tenants.edit', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push($tenant->title, route('adminarea.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.tenants.logs', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push($tenant->title, route('adminarea.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.logs'), route('adminarea.tenants.logs', ['tenant' => $tenant]));
});

Breadcrumbs::register('adminarea.tenants.media.index', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('adminarea.tenants.index');
    $breadcrumbs->push($tenant->title, route('adminarea.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('adminarea.tenants.media.index', ['tenant' => $tenant]));
});
