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
Route::resource('clients', ClientController::class)->except([
    'destroy'
]);

Route::resource('orders', OrderController::class)->except([
    'index'
]);

Route::resource('cars', CarController::class)->except([
    'index', 'show'
]);

Route::resource('items', ItemController::class)->except([
    'show'
]);
