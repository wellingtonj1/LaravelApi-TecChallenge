<?php

use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/sales')->group(function () {
    Route::post('/', [SaleController::class, 'createSale']);
    Route::get('{saleId}', [SaleController::class, 'getSale']);
    Route::get('/', [SaleController::class, 'getSales']);
});

Route::get('/products', [ProductController::class, 'index']);
