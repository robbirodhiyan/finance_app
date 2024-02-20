<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\transaction\pemasukan;
use App\Http\Controllers\transaction\pengeluaran;
use App\Models\Debit;
use App\Models\DebitLog;

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

Route::get('/user', [LoginBasic::class, 'user'])->name('api.user');
Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout');

// route group for authenticated users only here
Route::middleware(['auth'])->group(function () {
  Route::get('/debit-log/{idDebit}', [pemasukan::class,'debitLog'])->name('auth.debitlog');
  Route::get('/credit-log/{idCredit}', [pengeluaran::class,'creditLog'])->name('auth.debitlog');
});
