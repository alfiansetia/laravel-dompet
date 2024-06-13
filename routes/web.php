<?php

use App\Http\Controllers\CapitalController;
use App\Http\Controllers\CompController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\DompetController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ToolController;
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
    Route::get('/home/getdata', [HomeController::class, 'getData'])->name('home.get.data');
    Route::get('/home/getchart', [HomeController::class, 'getChart'])->name('home.get.chart');

    Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('user/profile', [UserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::get('user/password', [UserController::class, 'profile'])->name('user.password');
    Route::post('user/password', [UserController::class, 'passwordUpdate'])->name('user.password.update');

    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::get('report/get-data', [ReportController::class, 'getData'])->name('report.data');
    Route::get('report/get-date', [ReportController::class, 'getDate'])->name('report.date');

    Route::get('dompet', [DompetController::class, 'index'])->name('dompet.index');
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('capital', [CapitalController::class, 'index'])->name('capital.index');
    Route::get('expenditure', [ExpenditureController::class, 'index'])->name('expenditure.index');
    Route::get('user', [UserController::class, 'index'])->name('user.index');

    Route::resource('comp', CompController::class)->only(['index', 'store']);

    Route::get('database/detail/{file}', [DatabaseBackupController::class, 'download'])->name('database.download');
    Route::get('database', [DatabaseBackupController::class, 'index'])->name('database.index');
    Route::post('database', [DatabaseBackupController::class, 'store'])->name('database.store');
    Route::delete('database/{file}', [DatabaseBackupController::class, 'destroy'])->name('database.destroy');

    Route::get('tools/phpinfo', [ToolController::class, 'php_info'])->name('tool.phpinfo');
});
