<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\Api\OrderController;

// Route::get('/test', function () {
//     return response()->json(['message' => 'Hello from Laravel!']);
// });


Route::get('/menu-items', [MenuItemController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);

Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);