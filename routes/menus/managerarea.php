<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('managerarea.sidebar', function (MenuGenerator $menu) {
    $tenant = config('rinvex.tenants.active');
    $menu->findByTitleOrAdd(trans('cortex/tenants::common.tenant'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) use ($tenant) {
        $dropdown->route(['managerarea.tenants.edit'], trans('cortex/tenants::common.tenant'), 20, 'fa fa-building-o')->ifCan('update', $tenant);
    });
});
