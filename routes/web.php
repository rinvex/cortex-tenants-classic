<?php

declare(strict_types=1);

Route::group(['domain' => domain()], function () {

    Route::name('backend.')
         ->namespace('Cortex\Tenantable\Http\Controllers\Backend')
         ->middleware(['web', 'nohttpcache', 'can:access-dashboard'])
         ->prefix(config('rinvex.cortex.route.locale_prefix') ? '{locale}/backend' : 'backend')->group(function () {

        // Tenants Routes
        Route::name('tenants.')->prefix('tenants')->group(function () {
            Route::get('/')->name('index')->uses('TenantsController@index');
            Route::get('create')->name('create')->uses('TenantsController@form');
            Route::post('create')->name('store')->uses('TenantsController@store');
            Route::get('{tenant}')->name('edit')->uses('TenantsController@form')->where('tenant', '[0-9]+');
            Route::put('{tenant}')->name('update')->uses('TenantsController@update')->where('tenant', '[0-9]+');
            Route::get('{tenant}/logs')->name('logs')->uses('TenantsController@logs')->where('tenant', '[0-9]+');
            Route::delete('{tenant}')->name('delete')->uses('TenantsController@delete')->where('tenant', '[0-9]+');
        });
    });

});
