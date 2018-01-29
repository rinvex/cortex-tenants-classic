<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.tenants.index'], trans('cortex/tenants::common.tenants'), 20, 'fa fa-building-o')->ifCan('list-tenants')->activateOnRoute('adminarea.tenants');
    });
});

if (config('cortex.foundation.route.locale_prefix')) {
    $languageMenu = function (MenuGenerator $menu) {
        $menu->dropdown(function (MenuItem $dropdown) {
            foreach (app('laravellocalization')->getSupportedLocales() as $key => $locale) {
                $dropdown->url(app('laravellocalization')->localizeURL(request()->fullUrl(), $key), $locale['name']);
            }
        }, app('laravellocalization')->getCurrentLocaleNative(), 10, 'fa fa-globe');
    };

    Menu::register('tenantarea.header', $languageMenu);
    Menu::register('managerarea.header', $languageMenu);
}
