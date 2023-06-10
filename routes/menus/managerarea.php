<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('managerarea.header.user', function (MenuGenerator $menu) {
    $menu->dropdown(function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.cortex.tenants.tenants.edit'], trans('cortex/auth::common.settings'), 10, 'fa fa-building-o')->ifCan('update', app('request.tenant'));
    }, app('request.tenant')->name, 9, 'fa fa-briefcase');
});

if (config('cortex.foundation.route.locale_prefix')) {
    Menu::register('managerarea.header.language', function (MenuGenerator $menu) {
        $menu->dropdown(function (MenuItem $dropdown) {
            foreach (app('laravellocalization')->getSupportedLocales() as $key => $locale) {
                $dropdown->url(app('laravellocalization')->localizeURL(request()->fullUrl(), $key), $locale['name']);
            }
        }, app('laravellocalization')->getCurrentLocaleNative(), 10, 'fa fa-globe');
    });
}
