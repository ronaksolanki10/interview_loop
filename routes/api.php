<?php

use App\Http\Controllers\OrderController;
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

Route::resource('orders', OrderController::class, ['except' => ['index', 'create', 'edit', 'update']]);
Route::post('orders/list', [OrderController::class, 'index']);
Route::post('orders/{id}/add', [OrderController::class, 'attachProduct']);
Route::post('orders/{id}/remove', [OrderController::class, 'deAttachProduct']);
Route::post('orders/{id}/pay', [OrderController::class, 'pay']);