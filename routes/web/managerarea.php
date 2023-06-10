<?php

declare(strict_types=1);

use Cortex\Tenants\Http\Controllers\Managerarea\HomeController;
use Cortex\Tenants\Http\Controllers\Managerarea\GenericController;
use Cortex\Tenants\Http\Controllers\Managerarea\TenantsController;
use Cortex\Tenants\Http\Controllers\Managerarea\TenantsMediaController;

Route::domain('{managerarea}')->group(function () {
    Route::name('managerarea.')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(route_prefix('managerarea'))->group(function () {

            // Managerarea Home route
            Route::get('/')->name('home')->uses([HomeController::class, 'index']);
            Route::post('country')->name('country')->uses([GenericController::class, 'country']);

            // Managerarea edit tenant
             Route::name('cortex.tenants.tenants.')->prefix('tenants')->group(function () {
                 Route::get('edit')->name('edit')->uses([TenantsController::class, 'edit']);
                 Route::put('edit')->name('update')->uses([TenantsController::class, 'update']);

                 Route::name('media.')->prefix('media')->group(function () {
                     Route::delete('{media}')->name('destroy')->uses([TenantsMediaController::class, 'destroy']);
                 });
             });
         });
});
