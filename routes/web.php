<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Tenants\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Tenants Routes
        Route::name('tenants.')->prefix('tenants')->group(function () {
            Route::get('/')->name('index')->uses('TenantsController@index');
            Route::get('create')->name('create')->uses('TenantsController@form');
            Route::post('create')->name('store')->uses('TenantsController@store');
            Route::get('{tenant}')->name('edit')->uses('TenantsController@form');
            Route::put('{tenant}')->name('update')->uses('TenantsController@update');
            Route::get('{tenant}/logs')->name('logs')->uses('TenantsController@logs');
            Route::delete('{tenant}')->name('delete')->uses('TenantsController@delete');
        });
    });

});
