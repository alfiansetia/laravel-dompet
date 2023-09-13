<?php

use App\Http\Controllers\Api\DompetController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user/profile', [UserController::class, 'profile']);
    Route::put('user/profile', [UserController::class, 'profileUpdate']);

    Route::post('logout', [LoginController::class, 'logout']);

    Route::apiResource('transaksis', TransaksiController::class)->only(['index', 'show']);
    // Route::get('transaksis/{transaksi}', [TransaksiController::class, 'show']);

    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    // Route::get('users', [UserController::class, 'index']);

    Route::apiResource('dompets', DompetController::class)->only(['index', 'show']);
});

Route::post('login', [LoginController::class, 'login']);
