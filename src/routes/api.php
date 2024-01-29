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
    Route::get('/', [SaleController::class, 'getSales']);
    Route::get('/{saleId}', [SaleController::class, 'getSale']);
    Route::post('/', [SaleController::class, 'createSale']);
    Route::post('/{saleId}/add-product', [SaleController::class, 'addProductsToSale']);
    Route::delete('/{saleId}', [SaleController::class, 'cancelSale']);

});

Route::get('/products', [ProductController::class, 'index']);
