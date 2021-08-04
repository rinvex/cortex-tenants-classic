<?php

declare(strict_types=1);

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Tenants\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(route_prefix('managerarea'))->group(function () {

             // Managerarea Home route
             Route::name('cortex.tenants.tenants.')->prefix('tenants')->group(function () {
                 Route::get('edit')->name('edit')->uses('TenantsController@edit');
                 Route::put('edit')->name('update')->uses('TenantsController@update');
                 Route::name('media.')->prefix('media')->group(function () {
                     Route::delete('{media}')->name('destroy')->uses('TenantsMediaController@destroy');
                 });
             });
         });
});
