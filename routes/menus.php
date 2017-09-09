<?php

declare(strict_types=1);

Menu::adminareaSidebar('resources')->routeIfCan('list-tenants', 'adminarea.tenants.index', '<i class="fa fa-building-o"></i> <span>'.trans('cortex/tenants::common.tenants').'</span>');
