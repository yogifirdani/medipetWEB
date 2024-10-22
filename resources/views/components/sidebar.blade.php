<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/admin') }}">MEDIPET</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Medipet</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Beranda Admin</li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fa-brands fa-shopify"></i><span>Produk</span></a>
                <ul class="dropdown-menu">
                    <li class=''>
                        <a class="nav-link" href="/transaksi"><i class="fa-solid fa-bag-shopping"></i><span> Pesanan Produk</span></a>
                    </li>
                    <li class=" ">
                        <a class="nav-link" href="/products"><i class="fa-solid fa-store"></i><span> Kelola Produk</span></a>
                    </li>
                    <li class=" ">
                        <a class="nav-link" href="/restocks"><i class="fa-solid fa-square-plus"></i><span> Restock Produk</span></a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-suitcase-medical"></i><span>Layanan Kesehatan</span></a>
                <ul class="dropdown-menu">
                    <li class=" ">
                        <a class="nav-link" href="/categories"><i class="fa-solid fa-notes-medical"></i><span> Kategori Layanan</span></a>
                    </li>
                    <li class="{{ Request::is('layanan') ? 'active' : '' }}">
                        <a class="nav-link" href="/orders"><i class="fa-regular fa-calendar"></i>
                            <span>Pemesanan Layanan</span></a>
                    </li>
                </ul>
            </li>

            <li class="{{ Request::is('konsultasi') ? 'active' : '' }}">
                <a class="nav-link" href="/konsultasiadmin"><i class="fa-regular fa-comment-dots"></i>
                    <span>Konsultasi</span></a>
            </li>

            <div class="hide-sidebar-mini mt-4 mb-4 p-3">
                <a href="/catalogs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                    <i class="fas fa-rocket"></i> Katalog
                </a>
            </div>
    </aside>
</div>
