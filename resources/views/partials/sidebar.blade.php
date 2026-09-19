        <aside id="sidebar-wrapper">

            <div class="sidebar-brand">
                <a href="/">
                    <div class="brand-badge"><i class="fas fa-boxes-stacked"></i></div>
                    <span>Sansin</span>
                </a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="/">
                    <div class="brand-badge"><i class="fas fa-boxes-stacked"></i></div>
                </a>
            </div>

            <ul class="sidebar-menu">
                @if (auth()->user()->role->role === 'admin')
                <li class="sidebar-item {{ Request::is('/') || Request::is('dashboard') || Request::is('home') ? 'active' : '' }}">
                    <a class="nav-link" href="/">
                        <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="menu-header">Master Data</li>
                @php
                    $isMasterActive = Request::is('penjualan-barang*') || Request::is('pembelian-barang*') || Request::is('kategori*') || Request::is('supplier*') || Request::is('satuan*');
                @endphp
                <li class="dropdown {{ $isMasterActive ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-boxes"></i> <span>Master Produk</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('penjualan-barang*') ? 'active' : '' }}">
                            <a class="nav-link {{ Request::is('penjualan-barang*') ? 'active' : '' }}" href="/penjualan-barang">Penjualan Barang</a>
                        </li>
                        <li class="{{ Request::is('pembelian-barang*') ? 'active' : '' }}">
                            <a class="nav-link {{ Request::is('pembelian-barang*') ? 'active' : '' }}" href="/pembelian-barang">Pembelian Barang</a>
                        </li>
                        <li class="{{ Request::is('kategori*') ? 'active' : '' }}">
                            <a class="nav-link {{ Request::is('kategori*') ? 'active' : '' }}" href="/kategori">Kategori</a>
                        </li>
                        <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
                            <a class="nav-link {{ Request::is('supplier*') ? 'active' : '' }}" href="/supplier">Supplier</a>
                        </li>
                        <li class="{{ Request::is('satuan*') ? 'active' : '' }}">
                            <a class="nav-link {{ Request::is('satuan*') ? 'active' : '' }}" href="/satuan">Satuan</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item {{ Request::is('karyawan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('karyawan*') ? 'active' : '' }}" href="/karyawan">
                        <i class="fas fa-users"></i> <span class="align-middle">Karyawan</span>
                    </a>
                </li>

                <li class="menu-header">Transaksi</li>
                <li class="sidebar-item {{ Request::is('produk-masuk*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('produk-masuk*') ? 'active' : '' }}" href="/produk-masuk">
                        <i class="fas fa-file-import"></i> <span class="align-middle">Produk Masuk</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('produk-keluar*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('produk-keluar*') ? 'active' : '' }}" href="/produk-keluar">
                        <i class="fas fa-file-export"></i> <span class="align-middle">Produk Keluar</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('menu-penjualan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('menu-penjualan*') ? 'active' : '' }}" href="/menu-penjualan">
                        <i class="fas fa-cart-shopping"></i> <span class="align-middle">Menu Penjualan (POS)</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/pesanan-online*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('admin/pesanan-online*') ? 'active' : '' }}" href="/admin/pesanan-online">
                        <i class="fas fa-truck-fast text-warning"></i> <span class="align-middle">Pesanan Online (Web)</span>
                    </a>
                </li>

                <li class="menu-header">Laporan</li>
                <li class="sidebar-item {{ Request::is('stok-produk*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('stok-produk*') ? 'active' : '' }}" href="/stok-produk">
                        <i class="fas fa-calculator"></i> <span class="align-middle">Stok Produk</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-penjualan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-penjualan*') ? 'active' : '' }}" href="/laporan-penjualan">
                        <i class="fas fa-file-invoice"></i> <span class="align-middle">Penjualan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-produk-masuk*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-produk-masuk*') ? 'active' : '' }}" href="/laporan-produk-masuk">
                        <i class="fas fa-file-arrow-down"></i> <span class="align-middle">PPn Masukan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-produk-keluar*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-produk-keluar*') ? 'active' : '' }}" href="/laporan-produk-keluar">
                        <i class="fas fa-file-arrow-up"></i> <span class="align-middle">PPn Keluaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-ppn-keseluruhan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-ppn-keseluruhan*') ? 'active' : '' }}" href="/laporan-ppn-keseluruhan">
                        <i class="fas fa-wallet"></i> <span class="align-middle">PPn Keseluruhan</span>
                    </a>
                </li>
                @endif

                @if (auth()->user()->role->role === 'kepala toko')
                <li class="sidebar-item {{ Request::is('/') || Request::is('dashboard') || Request::is('home') ? 'active' : '' }}">
                    <a class="nav-link" href="/">
                        <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="menu-header">Laporan</li>
                <li class="sidebar-item {{ Request::is('stok-produk*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('stok-produk*') ? 'active' : '' }}" href="/stok-produk">
                        <i class="fas fa-calculator"></i> <span class="align-middle">Stok Produk</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-penjualan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-penjualan*') ? 'active' : '' }}" href="/laporan-penjualan">
                        <i class="fas fa-file-invoice"></i> <span class="align-middle">Penjualan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-produk-masuk*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-produk-masuk*') ? 'active' : '' }}" href="/laporan-produk-masuk">
                        <i class="fas fa-file-arrow-down"></i> <span class="align-middle">PPn Masukan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-produk-keluar*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-produk-keluar*') ? 'active' : '' }}" href="/laporan-produk-keluar">
                        <i class="fas fa-file-arrow-up"></i> <span class="align-middle">PPn Keluaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-ppn-keseluruhan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-ppn-keseluruhan*') ? 'active' : '' }}" href="/laporan-ppn-keseluruhan">
                        <i class="fas fa-wallet"></i> <span class="align-middle">PPn Keseluruhan</span>
                    </a>
                </li>
                @endif

                @if (auth()->user()->role->role === 'kasir')
                <li class="sidebar-item {{ Request::is('/') || Request::is('dashboard') || Request::is('home') ? 'active' : '' }}">
                    <a class="nav-link" href="/">
                        <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="menu-header">Transaksi</li>
                <li class="sidebar-item {{ Request::is('menu-penjualan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('menu-penjualan*') ? 'active' : '' }}" href="/menu-penjualan">
                        <i class="fas fa-cart-shopping"></i> <span class="align-middle">Menu Penjualan</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/pesanan-online*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('admin/pesanan-online*') ? 'active' : '' }}" href="/admin/pesanan-online">
                        <i class="fas fa-truck-fast text-warning"></i> <span class="align-middle">Pesanan Online (Web)</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('laporan-penjualan*') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('laporan-penjualan*') ? 'active' : '' }}" href="/laporan-penjualan">
                        <i class="fas fa-file-invoice"></i> <span class="align-middle">Penjualan</span>
                    </a>
                </li>
                @endif

            </ul>

        </aside>