<div class="nk-sidebar">
    <div class="nk-nav-scroll">

        <ul class="metismenu" id="menu">

            <li class="nav-label">Dashboard Admin</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Manajemen Data User</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('Guru.index') }}" class=" waves-effect">
                            <span>Data Guru</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Siswa.siswa') }}" class=" waves-effect">
                            <span>Data Siswa</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Petugas.index') }}" class=" waves-effect">
                            <span>Data Petugas</span>
                            </a>
                        </li>
                    </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Master Data</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('Kategori.kategori') }}" class=" waves-effect">
                            <span>Data Kategori</span>
                            </a>
                        </li>
                        <li><a href="{{ route('Kelas.kelas') }}" class=" waves-effect">
                            <span>Data Kelas </span>
                            </a>
                        </li>
                        <li><a href="{{ route('Jurusan.jurusan') }}" class=" waves-effect">
                            <span>Data Jurusan </span>
                            </a>
                        </li>
                        <li><a href="{{ route('Ruangan.ruangan') }}" class=" waves-effect">
                            <span>Data Ruangan  </span>
                            </a>
                        </li>
                    </ul>
            </li>


            <li>
                <a href="{{ route('Siswa.siswa') }}" aria-expanded="false">
                    <i class="icon-badge menu-icon"></i><span class="nav-text">Data Pengaduan</span>
                </a>
            </li>  
                      
        </ul>

    </div>
</div>
