<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StockEntryController;

Route::post('login', [AuthController::class, 'login']);

Route::get('stock', [StockEntryController::class, 'index']);
Route::middleware('auth:api')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('stock/bulk', [StockEntryController::class, 'storeBulk']);
    // Route::post('/stock/bulk', [StockEntryController::class, 'bulkStore']);
    Route::delete('stock/{id}', [StockEntryController::class, 'destroy']);
});
