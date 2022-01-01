<?php

declare(strict_types=1);

use Cortex\Tenants\Http\Middleware\SetSessionConfigRuntime;

return function () {
    // Bind route models and constrains
    Route::pattern('tenant', '[a-zA-Z0-9-_]+');
    Route::pattern('absentarea', '[a-zA-Z0-9\-\.]+');
    Route::pattern('centralarea', route_pattern());
    Route::pattern('frontarea', route_pattern('frontarea'));
    Route::pattern('adminarea', route_pattern('adminarea'));
    Route::pattern('tenantarea', route_pattern('tenantarea'));
    Route::pattern('managerarea', route_pattern('managerarea'));
    Route::model('tenant', config('rinvex.tenants.models.tenant'));
    Route::prependMiddlewareToGroup('web', SetSessionConfigRuntime::class);
};
