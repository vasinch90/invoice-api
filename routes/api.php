<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('invoices',              [InvoiceController::class, 'index']);
    Route::post('invoices',             [InvoiceController::class, 'store']);
    Route::get('invoices/{id}',         [InvoiceController::class, 'show']);
    Route::put('invoices/{id}/status',  [InvoiceController::class, 'updateStatus']);
    Route::get('dashboard/summary',     [DashboardController::class, 'summary']);
});