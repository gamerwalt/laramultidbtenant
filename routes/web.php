<?php


    Route::get('/tenants/select', 'SelectTenantController@index')->name('select.tenant');
    Route::post('/tenants/select', 'SelectTenantController@store')->name('select.tenant.store');
