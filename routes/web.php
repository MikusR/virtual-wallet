<?php

use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
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
    if (Auth::check()) {
        return redirect('/wallets');
    } else {
        return view('index');
    }
});
Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth');
Route::get('login', [SessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('login', [SessionController::class, 'store'])->middleware('guest');

Route::get('/wallets/create', [WalletController::class, 'create'])->middleware('auth');
Route::post('/wallets/create', [WalletController::class, 'store'])->middleware('auth');
Route::get('wallets', [WalletController::class, 'index'])->middleware('auth');
Route::get('/wallets/{id}', [WalletController::class, 'show'])
    ->middleware('auth')
    ->where('id', '[0-9]+')
    ->name('transactions');
Route::get('/wallets/{id}/edit', [WalletController::class, 'show'])->middleware('auth')->name('wallets.edit');
Route::post('/wallets/{id}/update', [WalletController::class, 'update'])->middleware('auth');
Route::post('/wallets/{id}/delete', [WalletController::class, 'destroy'])->middleware('auth');
Route::post('/wallets/{wallet_id}/transactions/{group_id}/delete',
    [TransactionController::class, 'destroy'])->middleware('auth')
    ->where('wallet_id', '[0-9]+');
Route::post('/wallets/{wallet_id}/transactions/{group_id}/mark-as-fraud',
    [TransactionController::class, 'mark'])->middleware('auth')
    ->where('wallet_id', '[0-9]+');
Route::post('/{user_id}/wallets/transactions/create',
    [TransactionController::class, 'store'])->middleware('auth')
    ->where('user_id', '[0-9]+');

Route::get('/wallets/{wallet_id}/transactions/create',
    [TransactionController::class, 'create'])->middleware('auth')
    ->where('wallet_id', '[0-9]+');

Route::get('/wallets/{wallet_id}/transactions/{group_id}',
    [TransactionController::class, 'show'])->middleware('auth')
    ->where('wallet_id', '[0-9]+');
