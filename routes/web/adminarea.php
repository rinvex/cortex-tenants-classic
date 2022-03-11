<?php

declare(strict_types=1);

use Cortex\Tenants\Http\Controllers\Adminarea\TenantsController;
use Cortex\Tenants\Http\Controllers\Adminarea\TenantsMediaController;

Route::domain('{adminarea}')->group(function () {
    Route::name('adminarea.')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(route_prefix('adminarea'))->group(function () {

        // Tenants Routes
             Route::name('cortex.tenants.tenants.')->prefix('tenants')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses([TenantsController::class, 'index']);
                 Route::post('import')->name('import')->uses([TenantsController::class, 'import']);
                 Route::get('create')->name('create')->uses([TenantsController::class, 'create']);
                 Route::post('create')->name('store')->uses([TenantsController::class, 'store']);
                 Route::get('{tenant}')->name('show')->uses([TenantsController::class, 'show']);
                 Route::get('{tenant}/edit')->name('edit')->uses([TenantsController::class, 'edit']);
                 Route::put('{tenant}/edit')->name('update')->uses([TenantsController::class, 'update']);
                 Route::match(['get', 'post'], '{tenant}/logs')->name('logs')->uses([TenantsController::class, 'logs']);
                 Route::delete('{tenant}')->name('destroy')->uses([TenantsController::class, 'destroy']);

                 Route::name('media.')->prefix('{tenant}/media')->group(function () {
                     Route::get('/')->name('index')->uses([TenantsMediaController::class, 'index']);
                     Route::post('/')->name('store')->uses([TenantsMediaController::class, 'store']);
                     Route::delete('{media}')->name('destroy')->uses([TenantsMediaController::class, 'destroy']);
                 });
             });
         });
});
