<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::resource('users', UserController::class)->except('create', 'edit');
Route::resource('clients', ClientController::class)->except('create', 'edit');
Route::resource('products', ProductController::class)->except('create', 'edit');
Route::get('clients/indexUser/{id}', [ClientController::class, 'indexUser']);
Route::get('products/indexClient/{id}', [ProductController::class, 'indexClient']);
