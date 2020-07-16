<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('managerarea.header.user', function (MenuGenerator $menu) {
    $menu->dropdown(function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.tenants.edit'], trans('cortex/auth::common.settings'), 10, 'fa fa-building-o')->ifCan('update', app('request.tenant'));
    }, app('request.tenant')->name, 9, 'fa fa-briefcase');
});
