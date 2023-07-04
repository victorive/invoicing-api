<?php

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\LogoutController;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\API\V1\ItemController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)
        ->middleware('auth:sanctum')->name('logout');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('items')->group(function () {
        Route::post('/', [ItemController::class, 'createItem']);
        Route::get('/', [ItemController::class, 'getAllItems']);
        Route::get('/{item}', [ItemController::class, 'findItemById']);
        Route::put('/{item}', [ItemController::class, 'updateItem']);
        Route::delete('/{item}', [ItemController::class, 'deleteItem']);
    });

    Route::prefix('invoices')->group(function () {
        Route::post('/', [InvoiceController::class, 'createInvoice']);
        Route::get('/', [InvoiceController::class, 'getAllInvoices']);
        Route::get('/{invoice}', [InvoiceController::class, 'findInvoiceById']);
        Route::delete('/{invoice}', [InvoiceController::class, 'deleteInvoice']);
    });
});
