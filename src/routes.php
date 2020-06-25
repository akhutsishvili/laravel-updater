<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('laravel-updater.route'), 'namespace' => 'Demafelix\LaravelUpdater\Controllers'], function () {
    Route::get('/', 'LaravelUpdaterController@index');
    Route::post('/', 'LaravelUpdaterController@update')->middleware('laravel-updater');
});