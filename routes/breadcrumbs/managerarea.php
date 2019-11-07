<?php

declare(strict_types=1);

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.tenants.edit', function (BreadcrumbsGenerator $breadcrumbs) {
    $tenant = config('rinvex.tenants.active');
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('managerarea.home'));
    $breadcrumbs->push($tenant->name, route('managerarea.tenants.edit', ['tenant' => $tenant]));
});
Breadcrumbs::register('managerarea.tenants.media.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $tenant = config('rinvex.tenants.active');
    $breadcrumbs->parent('managerarea.tenants.edit');
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('managerarea.tenants.media.index', ['tenant' => $tenant]));
});
