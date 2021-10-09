<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('tenant', '[a-zA-Z0-9-_]+');
    Route::pattern('routeDomain', route_domains_pattern());
    Route::model('tenant', config('rinvex.tenants.models.tenant'));
};
