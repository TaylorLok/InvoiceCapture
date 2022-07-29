<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::post('login','Api\AuthController@login');

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');

Route::get('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');

//invoice
Route::post('/invoices/postCreate', [App\Http\Controllers\Api\InvoiceController::class, 'postCreate'])->middleware('jwtAuth');

Route::post('/invoices/update', [App\Http\Controllers\Api\InvoiceController::class, 'update'])->middleware('jwtAuth');

Route::post('/invoices/delete', [App\Http\Controllers\Api\InvoiceController::class, 'delete'])->middleware('jwtAuth');

Route::get('/invoices/display_invoice', [App\Http\Controllers\Api\InvoiceController::class, 'display_invoice'])->middleware('jwtAuth');
