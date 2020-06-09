<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('managerarea.header.user', function (MenuGenerator $menu) {
    $tenant = config('rinvex.tenants.active');
    $menu->dropdown(function (MenuItem $dropdown) use ($tenant) {
        $dropdown->route(['managerarea.tenants.edit'], trans('cortex/auth::common.settings'), 10, 'fa fa-building-o');
    }, $tenant->name, 9, 'fa fa-briefcase');
});
