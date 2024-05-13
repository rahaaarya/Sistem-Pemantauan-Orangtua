<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;



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

// Route default mengarahkan pengguna ke halaman login
Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register-proses', [RegisterController::class, 'register_proses'])->name('register-proses');;

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/user', [HomeController::class, 'index'])->name('index');
    Route::get('/create', [HomeController::class, 'create'])->name('mahasiswa.create');
    Route::post('/store', [HomeController::class, 'store'])->name('mahasiswa.store');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/update/{id}', [HomeController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('mahasiswa.delete');
});
