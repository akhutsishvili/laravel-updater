<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'laravel-updater', 'prefix' => config('laravel-updater.route'), 'namespace' => 'Demafelix\LaravelUpdater\Controllers'], function () {
    Route::get('/', 'LaravelUpdaterController@index');
    Route::post('/', 'LaravelUpdaterController@update');
});