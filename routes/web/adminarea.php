<?php

declare(strict_types=1);

Route::domain('{central_domain}')->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Tenants\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(route_prefix('adminarea'))->group(function () {

        // Tenants Routes
             Route::name('cortex.tenants.tenants.')->prefix('tenants')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses('TenantsController@index');
                 Route::get('import')->name('import')->uses('TenantsController@import');
                 Route::post('import')->name('stash')->uses('TenantsController@stash');
                 Route::post('hoard')->name('hoard')->uses('TenantsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('TenantsController@importLogs');
                 Route::get('create')->name('create')->uses('TenantsController@create');
                 Route::post('create')->name('store')->uses('TenantsController@store');
                 Route::get('{tenant}')->name('show')->uses('TenantsController@show');
                 Route::get('{tenant}/edit')->name('edit')->uses('TenantsController@edit');
                 Route::put('{tenant}/edit')->name('update')->uses('TenantsController@update');
                 Route::match(['get', 'post'], '{tenant}/logs')->name('logs')->uses('TenantsController@logs');
                 Route::delete('{tenant}')->name('destroy')->uses('TenantsController@destroy');

                 Route::name('media.')->prefix('{tenant}/media')->group(function () {
                     Route::get('/')->name('index')->uses('TenantsMediaController@index');
                     Route::post('/')->name('store')->uses('TenantsMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('TenantsMediaController@destroy');
                 });
             });
         });
});
