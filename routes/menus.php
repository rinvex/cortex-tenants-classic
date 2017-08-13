<?php

declare(strict_types=1);

Menu::backendSidebar('resources')->routeIfCan('list-tenants', 'backend.tenants.index', '<i class="fa fa-building-o"></i> <span>'.trans('cortex/tenantable::common.tenants').'</span>');
