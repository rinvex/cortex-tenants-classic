<?php

declare(strict_types=1);

use Cortex\Tenants\Http\Controllers\Tenantarea\HomeController;
use Cortex\Tenants\Http\Controllers\Tenantarea\GenericController;

Route::domain('{tenantarea}')->group(function () {
    Route::name('tenantarea.')
         ->middleware(['web'])
         ->prefix(route_prefix('tenantarea'))->group(function () {
             // Homepage Routes
             Route::get('/')->name('home')->uses([HomeController::class, 'index']);
             Route::post('country')->name('country')->uses([GenericController::class, 'country']);
         });
});
