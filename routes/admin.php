<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\SuratPengantar\PklController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class, 'index'])->name('auth.login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login.process');

Route::group(['middleware' => 'auth.employee'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::group(['as' => 'surat-pengantar.', 'prefix' => 'surat-pengantar'], function() {
        // Bagian pkl
        Route::get('pkl', [PklController::class, 'index'])->name('pkl.index');
        Route::get('pkl/{submission}', [PklController::class, 'show'])->name('pkl.show');
        Route::post('pkl/{submission}', [PklController::class, 'update'])->name('pkl.update');
    });
});
