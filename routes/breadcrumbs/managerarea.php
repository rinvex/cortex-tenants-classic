<?php

declare(strict_types=1);

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.tenants.edit', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('managerarea.home'));
    $breadcrumbs->push(strip_tags(app('request.tenant')->name), route('managerarea.tenants.edit', ['tenant' => app('request.tenant')]));
});
Breadcrumbs::register('managerarea.tenants.media.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.tenants.edit');
    $breadcrumbs->push(trans('cortex/tenants::common.media'), route('managerarea.tenants.media.index', ['tenant' => app('request.tenant')]));
});
