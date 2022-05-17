<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use Rinvex\Menus\Models\MenuItem;
use Cortex\Foundation\Models\Media;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', 'header', [], [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.cortex.tenants.tenants.index'], trans('cortex/tenants::common.tenants'), 20, 'fa fa-building-o')->ifCan('list', app('rinvex.tenants.tenant'))->activateOnRoute('adminarea.cortex.tenants.tenants');
    });
});

Menu::register('adminarea.cortex.tenants.tenants.tabs', function (MenuGenerator $menu, Tenant $tenant, Media $media) {
    $menu->route(['adminarea.cortex.tenants.tenants.import'], trans('cortex/tenants::common.records'))->ifCan('import', $tenant)->if(Route::is('adminarea.cortex.tenants.tenants.import*'));
    $menu->route(['adminarea.cortex.tenants.tenants.import.logs'], trans('cortex/tenants::common.logs'))->ifCan('import', $tenant)->if(Route::is('adminarea.cortex.tenants.tenants.import*'));
    $menu->route(['adminarea.cortex.tenants.tenants.create'], trans('cortex/tenants::common.details'))->ifCan('create', $tenant)->if(Route::is('adminarea.cortex.tenants.tenants.create'));
    $menu->route(['adminarea.cortex.tenants.tenants.edit', ['tenant' => $tenant]], trans('cortex/tenants::common.details'))->ifCan('update', $tenant)->if($tenant->exists);
    $menu->route(['adminarea.cortex.tenants.tenants.logs', ['tenant' => $tenant]], trans('cortex/tenants::common.logs'))->ifCan('audit', $tenant)->if($tenant->exists);
    $menu->route(['adminarea.cortex.tenants.tenants.media.index', ['tenant' => $tenant]], trans('cortex/tenants::common.media'))->ifCan('update', $tenant)->ifCan('list', $media)->if($tenant->exists);
});
