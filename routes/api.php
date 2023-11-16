<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Users\IndexController as UsersIndex;
use App\Http\Controllers\API\Users\StoreController as UsersStore;
use App\Http\Controllers\API\Transactions\StoreController as TransactionsStore;

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

Route::get('/users', UsersIndex::class);
Route::post('/users/store', UsersStore::class);

Route::post('/transactions/store', TransactionsStore::class);

