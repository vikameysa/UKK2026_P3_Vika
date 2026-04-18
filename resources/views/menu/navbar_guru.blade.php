<div class="nk-sidebar">
    <div class="nk-nav-scroll">

        <ul class="metismenu" id="menu">

            <li class="nav-label">Dashboard Guru</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-label">Menu Aspirasi</li>

            <li>
                <a href="{{ route('guru.aspirasi.create') }}" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Buat Aspirasi</span>
                </a>
            </li>  
            <li>
                <a href="{{ route('guru.aspirasi.index') }}" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Daftar Aspirasi</span>
                </a>
            </li>  
            <li>
                <a href="{{ route('guru.aspirasi.history') }}" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">History Aspirasi</span>
                </a>
            </li>        
        </ul>

    </div>
</div>
