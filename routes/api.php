<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Restoran Mobile API
|--------------------------------------------------------------------------
| These routes are intended for the mobile app.
| They are stateless (no sessions) and return JSON responses.
| Prefix: /api
*/

// Menu & Categories
Route::get('/categories', [ApiController::class, 'categories']);
Route::get('/menu',       [ApiController::class, 'menu']);
Route::post('/sync-state', [ApiController::class, 'syncState']);
Route::post('/upload-image', [ApiController::class, 'uploadImage']);

// Orders
Route::get('/orders',     [ApiController::class, 'listOrders']);
Route::get('/orders/{id}',[ApiController::class, 'showOrder']);
Route::post('/orders',    [ApiController::class, 'createOrder']);
