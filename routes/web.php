<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrangtuaController;
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
    Route::get('/mahasiswa', [HomeController::class, 'index'])->name('index');

    Route::get('/create', [HomeController::class, 'create'])->name('mahasiswa.create');
    Route::post('/store', [HomeController::class, 'store'])->name('mahasiswa.store');
    Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/update/{id}', [HomeController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('mahasiswa.delete');

    // Rute untuk orang tua
    Route::get('/orangtua', [OrangtuaController::class, 'index'])->name('orangtua.index');
    Route::get('/orangtua/create', [OrangtuaController::class, 'create'])->name('orangtua.create');
    Route::post('/orangtua/store', [OrangtuaController::class, 'store'])->name('orangtua.store');
    Route::get('/orangtua/edit/{id_orangtua}', [OrangtuaController::class, 'edit'])->name('orangtua.edit');
    Route::put('/orangtua/update/{id_orangtua}', [OrangtuaController::class, 'update'])->name('orangtua.update');
    Route::delete('/orangtua/delete/{id_orangtua}', [OrangtuaController::class, 'delete'])->name('orangtua.delete');


    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/dosen/store', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/dosen/edit/{id}', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::put('/dosen/update/{id}', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/dosen/delete/{id}', [DosenController::class, 'delete'])->name('dosen.delete');
});
