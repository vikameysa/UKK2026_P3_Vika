@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Dashboard Admin</h3>
                    
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 mb-4">
                            <div class="card gradient-1">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Profil siswa</h5>
                                    <p class="text-white mb-1"><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                                    <p class="text-white mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                    <p class="text-white mb-0"><strong>Status:</strong> {{ Auth::user()->status }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 mb-4">
                            <div class="card gradient-2">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Total siswa</h5>
                                    <h2 class="text-white">{{ $totalSiswa ?? 0 }}</h2>
                                    <p class="text-white mb-0">Siswa Terdaftar</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Guru -->
                        <div class="col-lg-3 col-sm-6 mb-4">
                            <div class="card gradient-3">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Total guru</h5>
                                    <h2 class="text-white">{{ $totalGuru ?? 0 }}</h2>
                                    <p class="text-white mb-0">Guru Aktif</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Menu Cepat</h5>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('Antrian.antrian') }}" class="btn btn-primary btn-block">
                                <i class="mdi mdi-calendar-check"></i> Lihat Antrian
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('Pasien.pasien') }}" class="btn btn-info btn-block">
                                <i class="mdi mdi-account-multiple"></i> Daftar Pasien
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="mdi mdi-clipboard-list"></i> Riwayat Pemeriksaan
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('Dokter.edit', Auth::user()->id) }}" class="btn btn-secondary btn-block">
                                <i class="mdi mdi-pencil"></i> Edit Profil
                            </a>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <h5 class="mb-3">Informasi Penting</h5>
                            <div class="alert alert-info" role="alert">
                                <i class="mdi mdi-information"></i>
                                Selamat datang {{ Auth::user()->name }}! Anda login sebagai <strong>Dokter</strong>.
                                Gunakan menu di atas untuk mengelola antrian dan data pasien Anda.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
