<?php

declare(strict_types=1);

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Tenants\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.managerarea') : config('cortex.foundation.route.prefix.managerarea'))->group(function () {
            // Managerarea Home route
            Route::name('tenants.')->prefix('tenants')->group(function () {
                Route::get('edit')->name('edit')->uses('TenantsController@form');
                Route::put('edit')->name('update')->uses('TenantsController@process');
                Route::name('media.')->prefix('media')->group(function () {
                    Route::delete('{media}')->name('destroy')->uses('TenantsMediaController@destroy');
                });
            });
    });
});