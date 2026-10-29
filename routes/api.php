<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;


Route::post('/orders', [OrderController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/low-stock', [
    \App\Http\Controllers\Api\ProductController::class,
    'lowStock',
]);
Route::get('/orders/history', [
    \App\Http\Controllers\Api\OrderController::class,
    'history',
]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
