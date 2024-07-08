<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProductController;



Route::post('v1/register', [UserController::class, 'store'])->name('user.store');

Route::group([
    'prefix' => 'v1',
    'middleware' => 'auth:sanctum'
], function () {
    Route::apiResource('products', ProductController::class);
});
