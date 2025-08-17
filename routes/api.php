<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\CategoryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/reviews', [ReviewApiController::class, 'index']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/categories', [CategoryApiController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
});
