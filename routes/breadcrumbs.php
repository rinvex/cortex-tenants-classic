<?php

declare(strict_types=1);

use Cortex\Tenantable\Models\Tenant;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('backend.tenants.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.backend'), route('backend.home'));
    $breadcrumbs->push(trans('cortex/tenantable::common.tenants'), route('backend.tenants.index'));
});

Breadcrumbs::register('backend.tenants.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('backend.tenants.index');
    $breadcrumbs->push(trans('cortex/tenantable::common.create_tenant'), route('backend.tenants.create'));
});

Breadcrumbs::register('backend.tenants.edit', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('backend.tenants.index');
    $breadcrumbs->push($tenant->name, route('backend.tenants.edit', ['tenant' => $tenant]));
});

Breadcrumbs::register('backend.tenants.logs', function (BreadcrumbsGenerator $breadcrumbs, Tenant $tenant) {
    $breadcrumbs->parent('backend.tenants.index');
    $breadcrumbs->push($tenant->name, route('backend.tenants.edit', ['tenant' => $tenant]));
    $breadcrumbs->push(trans('cortex/tenantable::common.logs'), route('backend.tenants.logs', ['tenant' => $tenant]));
});
