<?php

use App\Http\Controllers\frontend\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register', [RegisterController::class, 'index'])->name('regsiter');
Route::any('/save_register', [RegisterController::class, 'saveRegister'])->name('add');
Route::get('/login', [RegisterController::class, 'login'])->name('login');
Route::post('/verify_login', [RegisterController::class, 'verifyLogin'])->name('login');
