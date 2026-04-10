<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/guru/dashboard', function () {
    return view('guru.dashboard');
})->name('guru.dashboard');

Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Untuk Guru
Route::get('/Guru', [GuruController::class, 'index'])->name('Guru.guru');
Route::get('/Guru/create', [GuruController::class, 'create'])->name('Guru.create');
Route::get('/Guru/edit/{id}', [GuruController::class, 'edit'])->name('Guru.edit');
Route::put('/Guru/update/{id}', [GuruController::class, 'update'])->name('Guru.update');
Route::post('/Guru/store', [GuruController::class, 'store'])->name('Guru.store');
Route::delete('/Guru/{id}', [GuruController::class, 'destroy'])->name('Guru.destroy');

// Untuk Siswa
Route::get('/Siswa', [SiswaController::class, 'index'])->name('Siswa.siswa');
Route::get('/Siswa/create', [SiswaController::class, 'create'])->name('Siswa.create');
Route::post('/Siswa', [SiswaController::class, 'store'])->name('Siswa.store');
Route::get('/Siswa/{id}/edit', [SiswaController::class, 'edit'])->name('Siswa.edit');
Route::put('/Siswa/{id}', [SiswaController::class, 'update'])->name('Siswa.update');
Route::delete('/Siswa/{id}', [SiswaController::class, 'destroy'])->name('Siswa.destroy');

