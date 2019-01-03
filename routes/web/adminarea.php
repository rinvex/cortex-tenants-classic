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
                 Route::get('import')->name('import')->uses('TenantsController@import');
                 Route::post('import')->name('stash')->uses('TenantsController@stash');
                 Route::post('hoard')->name('hoard')->uses('TenantsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('TenantsController@importLogs');
                 Route::get('create')->name('create')->uses('TenantsController@form');
                 Route::post('create')->name('store')->uses('TenantsController@store');
                 Route::get('{tenant}')->name('show')->uses('TenantsController@show');
                 Route::get('{tenant}/edit')->name('edit')->uses('TenantsController@form');
                 Route::put('{tenant}/edit')->name('update')->uses('TenantsController@update');
                 Route::get('{tenant}/logs')->name('logs')->uses('TenantsController@logs');
                 Route::delete('{tenant}')->name('destroy')->uses('TenantsController@destroy');

                 Route::name('media.')->prefix('{tenant}/media')->group(function () {
                     Route::get('/')->name('index')->uses('TenantsMediaController@index');
                     Route::post('/')->name('store')->uses('TenantsMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('TenantsMediaController@destroy');
                 });
             });
         });
});
