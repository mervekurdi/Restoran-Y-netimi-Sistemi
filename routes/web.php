<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;

Route::get('/', [RestaurantController::class, 'home'])->name('home');

Route::get('/menu', [RestaurantController::class, 'menu'])->name('menu');

Route::get('/cart', [RestaurantController::class, 'cart'])->name('cart');

Route::get('/orders', [RestaurantController::class, 'orders'])->name('orders');

Route::post('/cart/add/{id}', [RestaurantController::class, 'addToCart'])->name('cart.add');

Route::get('/cart/remove/{id}', [RestaurantController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/cart/increase/{id}', [RestaurantController::class, 'increase'])->name('cart.increase');

Route::get('/cart/decrease/{id}', [RestaurantController::class, 'decrease'])->name('cart.decrease');

Route::post('/order/confirm', [RestaurantController::class, 'confirmOrder'])->name('order.confirm');

