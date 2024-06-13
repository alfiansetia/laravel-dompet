<?php

use App\Http\Controllers\Api\CapitalController;
use App\Http\Controllers\Api\DompetController;
use App\Http\Controllers\Api\ExpenditureController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\StatisticController;
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

Route::group(['middleware' => ['auth:sanctum', 'active']], function () {

    Route::get('profile', [ProfileController::class, 'index'])->name('api.profile.index');
    Route::get('statistics', [StatisticController::class, 'get']);

    Route::group(['middleware' => ['active']], function () {

        Route::post('profile', [ProfileController::class, 'update'])->name('api.profile.update');

        Route::post('logout', [LoginController::class, 'logout']);

        Route::get('transaksi-paginate', [TransaksiController::class, 'paginate'])->name('api.transaksi.paginate');
        Route::apiResource('transaksis', TransaksiController::class)->names('api.transaksi');

        Route::get('capital-paginate', [CapitalController::class, 'paginate'])->name('api.capital.paginate');
        Route::apiResource('capitals', CapitalController::class)->names('api.capital');

        Route::get('expenditure-paginate', [ExpenditureController::class, 'paginate'])->name('api.capital.paginate');
        Route::apiResource('expenditures', ExpenditureController::class)->names('api.expenditure');

        Route::get('dompet-paginate', [DompetController::class, 'paginate'])->name('api.dompet.paginate');
        Route::apiResource('dompets', DompetController::class)->names('api.dompet');
        Route::delete('dompets', [DompetController::class, 'destroyBatch'])->name('api.dompet.destroy.batch');

        Route::get('user-paginate', [UserController::class, 'paginate'])->name('api.user.paginate');
        Route::apiResource('users', UserController::class)->names('api.user');
        Route::delete('users', [UserController::class, 'destroyBatch'])->name('api.user.destroy.batch');
    });
});

Route::post('login', [LoginController::class, 'login']);
