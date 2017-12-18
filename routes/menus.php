<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Factories\MenuFactory;

Menu::modify('adminarea.sidebar', function(MenuFactory $menu) {
    $menu->findBy('title', trans('cortex/foundation::common.crm'), function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.tenants.index'], trans('cortex/tenants::common.tenants'), 20, 'fa fa-building-o')->can('list-tenants');
    });
});

if (config('cortex.foundation.route.locale_prefix')) {
    $languageMenu = function(MenuFactory $menu) {
        $menu->dropdown(function(MenuItem $dropdown) {
            foreach (app('laravellocalization')->getSupportedLocales() as $key => $locale) {
                $dropdown->url(app('laravellocalization')->localizeURL(request()->fullUrl(), $key), $locale['name']);
            }
        }, app('laravellocalization')->getCurrentLocaleNative(), 10, 'fa fa-globe');
    };

    Menu::modify('tenantarea.topbar', $languageMenu);
    Menu::modify('managerarea.topbar', $languageMenu);
}
