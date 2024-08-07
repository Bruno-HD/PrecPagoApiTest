<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('/statistics', [TransactionController::class, 'index']);
Route::delete('/transactions', [TransactionController::class, 'destroy']);
