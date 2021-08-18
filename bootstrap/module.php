<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('tenant', '[a-zA-Z0-9-_]+');
    Route::model('tenant', config('rinvex.tenants.models.tenant'));
};
