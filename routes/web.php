<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\frontend\RegisterController;
use Illuminate\Support\Facades\Route;

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


Route::middleware('adminAll')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('logout', [DashboardController::class, 'logout']);

    Route::any('service', [ServiceController::class, 'index'])->name('service');
    Route::any('/add_service/{id}', [ServiceController::class, 'manageService']);
    Route::any('/save_service', [ServiceController::class, 'addUpdate']);
    Route::any('/fetch_service', [ServiceController::class, 'fetchService']);
    Route::any('/update_service/{id}', [ServiceController::class, 'manageService']);
    Route::any('/delete_service/{id}', [ServiceController::class, 'deleteService']);
});
