<?php

use App\Http\Controllers\DompetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
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

Auth::routes([
    'register' => false, // Routes of Registration
    'reset' => false,    // Routes of Password Reset
    'verify' => false,   // Routes of Email Verification
]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('user', UserController::class)->only(['index', 'store', 'show', 'update']);
    Route::delete('user', [UserController::class, 'destroy'])->name('user.destroy');

    Route::resource('dompet', DompetController::class)->only(['index', 'store', 'show', 'update']);
    Route::delete('dompet', [DompetController::class, 'destroy'])->name('dompet.destroy');

    Route::resource('transaksi', TransaksiController::class)->only(['index', 'store', 'show']);
});
