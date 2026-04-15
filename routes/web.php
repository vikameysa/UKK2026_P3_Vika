<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Guru\AspirasiController as GuruAspirasiController;
use App\Http\Controllers\Siswa\AspirasiController as SiswaAspirasiController;

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

// Pengaduan/Aspirasi Management
Route::get('/Pengaduan', [PengaduanController::class, 'index'])->name('Pengaduan.pengaduan');
Route::get('/Pengaduan/{id}', [PengaduanController::class, 'detail'])->name('Pengaduan.detail');
Route::post('/Pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('Pengaduan.status');
Route::post('/Pengaduan/{id}/feedback', [PengaduanController::class, 'storeFeedback'])->name('Pengaduan.feedback');
Route::post('/Pengaduan/{id}/progres', [PengaduanController::class, 'storeProgres'])->name('Pengaduan.progres');
Route::delete('/Pengaduan/{id}', [PengaduanController::class, 'destroyAspirasi'])->name('Pengaduan.destroy');

//aspirasi untuk guru
Route::prefix('guru')->group(function () {

    Route::get('/aspirasi', [GuruAspirasiController::class, 'index'])->name('guru.aspirasi.index');
    Route::get('/aspirasi/create', [GuruAspirasiController::class, 'create'])->name('guru.aspirasi.create');
    Route::post('/aspirasi', [GuruAspirasiController::class, 'store'])->name('guru.aspirasi.store');
    Route::get('/aspirasi/{id}', [GuruAspirasiController::class, 'detail'])->name('guru.aspirasi.detail');
    Route::post('/aspirasi/{id}/feedback', [GuruAspirasiController::class, 'storeFeedback'])->name('guru.aspirasi.feedback');
    Route::post('/aspirasi/{id}/progres', [GuruAspirasiController::class, 'storeProgres'])->name('guru.aspirasi.progres');
    Route::put('/aspirasi/{id}/status', [GuruAspirasiController::class, 'updateStatus'])->name('guru.aspirasi.status');
    Route::get('/history', [GuruAspirasiController::class, 'history'])->name('guru.aspirasi.history');
    Route::get('/statistik', [GuruAspirasiController::class, 'statistik'])->name('guru.statistik');
});

//aspirasi untuk siswa
Route::prefix('siswa')->group(function () {

    Route::get('/aspirasi', [SiswaAspirasiController::class, 'index'])->name('siswa.aspirasi.index');
    Route::get('/aspirasi/create', [SiswaAspirasiController::class, 'create'])->name('siswa.aspirasi.create');
    Route::post('/aspirasi', [SiswaAspirasiController::class, 'store'])->name('siswa.aspirasi.store');
    Route::get('/aspirasi/{id}', [SiswaAspirasiController::class, 'detail'])->name('siswa.aspirasi.detail');
    Route::get('/status', [SiswaAspirasiController::class, 'status'])->name('siswa.aspirasi.status');
    Route::get('/history', [SiswaAspirasiController::class, 'history'])->name('siswa.aspirasi.history');
    Route::post('/aspirasi/{id}/feedback', [SiswaAspirasiController::class, 'storeFeedback'])->name('siswa.aspirasi.feedback');

    Route::get('/profile', [SiswaAspirasiController::class, 'profile'])->name('siswa.profile');
});
