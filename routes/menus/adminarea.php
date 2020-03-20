<?php

declare(strict_types=1);

use Cortex\Tenants\Models\Tenant;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Tenant $tenant) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) use ($tenant) {
        $dropdown->route(['adminarea.tenants.index'], trans('cortex/tenants::common.tenants'), 20, 'fa fa-building-o')->ifCan('list', $tenant)->activateOnRoute('adminarea.tenants');
    });
});

Menu::register('adminarea.tenants.tabs', function (MenuGenerator $menu, Tenant $tenant, Media $media) {
    $menu->route(['adminarea.tenants.import'], trans('cortex/tenants::common.records'))->ifCan('import', $tenant)->if(Route::is('adminarea.tenants.import*'));
    $menu->route(['adminarea.tenants.import.logs'], trans('cortex/tenants::common.logs'))->ifCan('import', $tenant)->if(Route::is('adminarea.tenants.import*'));
    $menu->route(['adminarea.tenants.create'], trans('cortex/tenants::common.details'))->ifCan('create', $tenant)->if(Route::is('adminarea.tenants.create'));
    $menu->route(['adminarea.tenants.edit', ['tenant' => $tenant]], trans('cortex/tenants::common.details'))->ifCan('update', $tenant)->if($tenant->exists);
    $menu->route(['adminarea.tenants.logs', ['tenant' => $tenant]], trans('cortex/tenants::common.logs'))->ifCan('audit', $tenant)->if($tenant->exists);
    $menu->route(['adminarea.tenants.media.index', ['tenant' => $tenant]], trans('cortex/tenants::common.media'))->ifCan('update', $tenant)->ifCan('list', $media)->if($tenant->exists);
});
