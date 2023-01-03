<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('clients.index');
});

// ------------- Added by UI authentication
Auth::routes();

// ------------- Custom routes

Route::get('clients/search', [ClientController::class, 'search'])->name('clients.search');
Route::resource('clients', ClientController::class);

Route::patch('orders/{order}/finish', [OrderController::class, 'finish'])->name('orders.finish');
Route::resource('orders', OrderController::class)->except([
    'index'
]);

Route::patch('cars/{car}/removeservice', [CarController::class, 'remove_service'])->name('cars.remove_service');
Route::resource('cars', CarController::class)->except([
    'index', 'show'
]);

Route::get('items/search', [ItemController::class, 'search'])->name('items.search');
Route::resource('items', ItemController::class)->except([
    'show'
]);
