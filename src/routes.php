<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'laravel-updater', 'prefix' => '/updater'], function () {
    Route::get('/', function () {
        return 'Hello!';
    });
});