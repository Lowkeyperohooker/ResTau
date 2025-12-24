<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello from Laravel!']);
});

use App\Http\Controllers\MenuItemController;

// This will be accessible at http://localhost:8000/api/menu-items
Route::get('/menu-items', [MenuItemController::class, 'index']);


use App\Http\Controllers\Api\OrderController;

// ... existing routes ...

Route::post('/orders', [OrderController::class, 'store']);