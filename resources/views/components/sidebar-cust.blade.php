<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/admin') }}">MEDIPET</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">MEDIPET</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Beranda</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Data Diri</span></a>
                <ul class="dropdown-menu">
                    <li class=''>
                        <a class="nav-link" href="/history"><i class="fa-solid fa-bag-shopping"></i><span>Riwayat Pesanan</span></a>
                    </li>
                    <li class=" ">
                        <a class="nav-link" href="/profile"><i class="fa-regular fa-user"></i><span>Profile</span></a>
                    </li>

                </ul>
            </li>

            {{-- <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="/Katalog"><i class="far fa-square"></i>
                    <span>Katalog</span></a>
            </li> --}}

            <li class="{{ Request::is('konsultasi') ? 'active' : '' }}">
                <a class="nav-link" href="/konsultasi"><i class="fa-regular fa-comment-dots"></i>
                    <span>Konsultasi</span></a>
            </li>

            <li class="{{ Request::is('bookings.create') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('bookings/create') }}"><i class="fa-solid fa-suitcase-medical"></i>
                    <span>Layanan</span></a>
            </li>


            <div class="hide-sidebar-mini mt-4 mb-4 p-3">
                <a href="/catalogs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                    <i class="fas fa-rocket"></i> Katalog
                </a>
            </div>
    </aside>
</div>
