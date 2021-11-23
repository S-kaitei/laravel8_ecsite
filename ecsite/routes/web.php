<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show']);

Route::get('/cart_item', [CartController::class, 'index']);
Route::post('/cart_item', [CartController::class, 'store']);
Route::get('/buy', [CartController::class, 'buy']);
Route::post('/buy', [CartController::class, 'buy_store']);
Route::delete('/cart_item/{cart_item}', [CartController::class, 'destroy']);
Route::put('/cart_item/{cart_item}', [CartController::class, 'update']);
