<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

if (config('cortex.foundation.route.locale_prefix')) {
    Menu::register('tenantarea.header.language', function (MenuGenerator $menu) {
        $menu->dropdown(function (MenuItem $dropdown) {
            foreach (app('laravellocalization')->getSupportedLocales() as $key => $locale) {
                $dropdown->url(app('laravellocalization')->localizeURL(request()->fullUrl(), $key), $locale['name']);
            }
        }, app('laravellocalization')->getCurrentLocaleNative(), 10, 'fa fa-globe');
    });
}

Menu::register('tenantarea.header.navigation', function (MenuGenerator $menu) {
    $menu->url(route('tenantarea.home'), 'Home', null, null, ['class' => 'smothscroll'])->if(! Route::is('tenantarea.home'));
    $menu->url('#home', 'Home', null, null, ['class' => 'smothscroll'])->if(Route::is('tenantarea.home'));
    $menu->url('#desc', 'Description', null, null, ['class' => 'smothscroll'])->if(Route::is('tenantarea.home'));
    $menu->url('#contact', 'Contact', null, null, ['class' => 'smothscroll'])->if(Route::is('tenantarea.home'));
});
