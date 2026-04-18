<div class="nk-sidebar">
    <div class="nk-nav-scroll">

        <ul class="metismenu" id="menu">

            <li class="nav-label">Dashboard Petugas</li>

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon-speedometer menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-label">Menu Aspirasi</li>

            <li>
                <a href="{{ route('Pengaduan.pengaduan') }}" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">Data Aspirasi</span>
                </a>
            </li>  
            <li>
                <a href="{{ route('petugas.aspirasi.index') }}" aria-expanded="false">
                    <i class="icon-note menu-icon"></i><span class="nav-text">History Aspirasi</span>
                </a>
            </li>        

            </li>
                
            
        </ul>

    </div>
</div>
