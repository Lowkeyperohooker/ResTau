<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return ['status' => 'Restau POS Backend is running!'];
});

Route::get('/', function () {
    return 'Restau POS API is working correctly.';
});