<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KategoriController;

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

Route::get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
})->name('petugas.dashboard');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Untuk Guru
// CRUD Guru
Route::get('/Guru', [GuruController::class, 'index'])->name('Guru.index');
Route::get('/Guru/create', [GuruController::class, 'create'])->name('Guru.create');
Route::post('/Guru/store', [GuruController::class, 'store'])->name('Guru.store');
Route::get('/Guru/edit/{id}', [GuruController::class, 'edit'])->name('Guru.edit');
Route::put('/Guru/update/{id}', [GuruController::class, 'update'])->name('Guru.update');
Route::delete('/Guru/{id}', [GuruController::class, 'destroy'])->name('Guru.destroy');

// Untuk Siswa
Route::get('/Siswa', [SiswaController::class, 'index'])->name('Siswa.siswa');
Route::get('/Siswa/create', [SiswaController::class, 'create'])->name('Siswa.create');
Route::post('/Siswa/store', [SiswaController::class, 'store'])->name('Siswa.store');
Route::get('/Siswa/edit/{id}', [SiswaController::class, 'edit'])->name('Siswa.edit');
Route::put('/Siswa/update/{id}', [SiswaController::class, 'update'])->name('Siswa.update');
Route::delete('/Siswa/{id}', [SiswaController::class, 'destroy'])->name('Siswa.destroy');

// Untuk Petugas
Route::get('/Petugas', [PetugasController::class, 'index'])->name('Petugas.index');
Route::get('/Petugas/create', [PetugasController::class, 'create'])->name('Petugas.create');
Route::post('/Petugas/store', [PetugasController::class, 'store'])->name('Petugas.store');
Route::get('/Petugas/edit/{id}', [PetugasController::class, 'edit'])->name('Petugas.edit');
Route::put('/Petugas/update/{id}', [PetugasController::class, 'update'])->name('Petugas.update');
Route::delete('/Petugas/{id}', [PetugasController::class, 'destroy'])->name('Petugas.destroy');

// Master Data
// Untuk Kategori
Route::get('/Kategori', [KategoriController::class, 'index'])->name('Kategori.kategori');
Route::get('/Kategori/create', [KategoriController::class, 'create'])->name('Kategori.create');
Route::post('/Kategori/store', [KategoriController::class, 'store'])->name('Kategori.store');
Route::get('/Kategori/edit/{id}', [KategoriController::class, 'edit'])->name('Kategori.edit');
Route::put('/Kategori/update/{id}', [KategoriController::class, 'update'])->name('Kategori.update');
Route::delete('/Kategori/{id}', [KategoriController::class, 'destroy'])->name('Kategori.destroy');

// Untuk Kelas
Route::get('/Kelas', [KelasController::class, 'index'])->name('Kelas.kelas');
Route::get('/Kelas/create', [KelasController::class, 'create'])->name('Kelas.create');
Route::post('/Kelas/store', [KelasController::class, 'store'])->name('Kelas.store');
Route::get('/Kelas/edit/{id}', [KelasController::class, 'edit'])->name('Kelas.edit');
Route::put('/Kelas/update/{id}', [KelasController::class, 'update'])->name('Kelas.update');
Route::delete('/Kelas/{id}', [KelasController::class, 'destroy'])->name('Kelas.destroy');

//Untuk Jurusan
Route::get('/Jurusan', [JurusanController::class, 'index'])->name('Jurusan.jurusan');
Route::get('/Jurusan/create', [JurusanController::class, 'create'])->name('Jurusan.create');
Route::post('/Jurusan/store', [JurusanController::class, 'store'])->name('Jurusan.store');
Route::get('/Jurusan/edit/{id}', [JurusanController::class, 'edit'])->name('Jurusan.edit');
Route::put('/Jurusan/update/{id}', [JurusanController::class, 'update'])->name('Jurusan.update');
Route::delete('/Jurusan/{id}', [JurusanController::class, 'destroy'])->name('Jurusan.destroy');

//Untuk Ruangan
Route::get('/Ruangan', [RuanganController::class, 'index'])->name('Ruangan.ruangan');
Route::get('/Ruangan/create', [RuanganController::class, 'create'])->name('Ruangan.create');
Route::post('/Ruangan/store', [RuanganController::class, 'store'])->name('Ruangan.store');
Route::get('/Ruangan/edit/{id}', [RuanganController::class, 'edit'])->name('Ruangan.edit');
Route::put('/Ruangan/update/{id}', [RuanganController::class, 'update'])->name('Ruangan.update');
Route::delete('/Ruangan/{id}', [RuanganController::class, 'destroy'])->name('Ruangan.destroy');