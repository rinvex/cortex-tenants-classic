<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('tenant', '[a-zA-Z0-9-_]+');
    Route::pattern('tenantarea', route_pattern('tenantarea'));
    Route::pattern('managerarea', route_pattern('managerarea'));
    Route::model('tenant', config('rinvex.tenants.models.tenant'));
};
