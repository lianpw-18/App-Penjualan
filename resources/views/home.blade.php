@extends('layouts.app')

@section('content')
<div class="dashboard-wrapper">

    {{-- 1. Top Welcome Banner & Quick Action Bar --}}
    <div class="welcome-banner mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-3">
                    <div class="user-avatar-box">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        @php
                            $hour = (int)date('H');
                            if ($hour >= 4 && $hour < 11) $greeting = 'Selamat Pagi';
                            elseif ($hour >= 11 && $hour < 15) $greeting = 'Selamat Siang';
                            elseif ($hour >= 15 && $hour < 18) $greeting = 'Selamat Sore';
                            else $greeting = 'Selamat Malam';
                        @endphp
                        <span class="badge bg-white text-dark shadow-sm px-3 py-1 rounded-pill mb-1 fw-bold">
                            <i class="fa-solid fa-shield-halved text-primary me-1"></i> {{ strtoupper(auth()->user()->role->role ?? 'Petugas') }}
                        </span>
                        <h2 class="welcome-title mb-1">{{ $greeting }}, {{ auth()->user()->name }}! 👋</h2>
                        <p class="welcome-subtitle mb-0 text-white-50">
                            <i class="fa-regular fa-calendar-days me-1"></i> {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }} 
                            • <i class="fa-regular fa-clock ms-2 me-1"></i> <span id="liveClock">{{ date('H:i') }} WIB</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-light btn-sm rounded-pill px-3 py-2 fw-bold shadow-sm text-dark">
                        <i class="fa-solid fa-globe text-primary me-1"></i> Katalog Publik
                    </a>
                    <a href="{{ url('/menu-penjualan') }}" class="btn btn-warning btn-sm rounded-pill px-3 py-2 fw-bold shadow-sm text-dark">
                        <i class="fa-solid fa-cash-register me-1"></i> Buka Kasir (POS)
                    </a>
                    <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2 fw-bold" onclick="confirmLogout()">
                        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Logout Form --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{-- 2. Financial Metrics Row --}}
    <div class="section-title-row d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-wallet text-primary me-2"></i>Ringkasan Keuangan Hari Ini</h5>
        <span class="badge bg-light text-muted border px-3 py-1 rounded-pill">Update Otomatis</span>
    </div>

    <div class="row g-3 mb-4">
        {{-- Pemasukan Hari Ini --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card metric-emerald">
                <div class="metric-body">
                    <div>
                        <div class="metric-label">Uang Masuk (Kas)</div>
                        <div class="metric-value">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</div>
                        <div class="metric-desc text-success">
                            <i class="fa-solid fa-arrow-trend-up me-1"></i> Pemasukan kas hari ini
                        </div>
                    </div>
                    <div class="metric-icon-circle">
                        <i class="fa-solid fa-arrow-down-left-and-up-right-to-center"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengeluaran Hari Ini --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card metric-rose">
                <div class="metric-body">
                    <div>
                        <div class="metric-label">Uang Keluar (Kas)</div>
                        <div class="metric-value">Rp {{ number_format($pengeluaranHariIni, 0, ',', '.') }}</div>
                        <div class="metric-desc text-danger">
                            <i class="fa-solid fa-arrow-trend-down me-1"></i> Biaya & pengeluaran
                        </div>
                    </div>
                    <div class="metric-icon-circle">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Saldo / Kas Bersih --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card metric-indigo">
                <div class="metric-body">
                    <div>
                        <div class="metric-label">Kas Bersih Hari Ini</div>
                        <div class="metric-value">Rp {{ number_format($pemasukanHariIni - $pengeluaranHariIni, 0, ',', '.') }}</div>
                        <div class="metric-desc text-primary">
                            <i class="fa-solid fa-scale-balanced me-1"></i> Saldo selisih harian
                        </div>
                    </div>
                    <div class="metric-icon-circle">
                        <i class="fa-solid fa-vault"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Penjualan Harian --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="metric-card metric-amber">
                <div class="metric-body">
                    <div>
                        <div class="metric-label">Omset Penjualan</div>
                        <div class="metric-value">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
                        <div class="metric-desc text-warning">
                            <i class="fa-solid fa-bag-shopping me-1"></i> {{ $transaksiHariIni ?? 0 }} Transaksi selesai
                        </div>
                    </div>
                    <div class="metric-icon-circle">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Stock Health & Inventory Overview Cards --}}
    <div class="section-title-row d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Status & Kesehatan Stok Barang</h5>
        <div class="d-flex align-items-center gap-2">
            <select class="form-select form-select-sm rounded-pill px-3" id="stokFilter" style="width: auto;">
                <option value="all">Semua Produk</option>
                <option value="pembelian">Pembelian (Bahan)</option>
                <option value="penjualan">Penjualan (Gamis)</option>
            </select>
            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="refreshStokData()">
                <i class="fa-solid fa-rotate me-1"></i> Sinkron Stok
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Total Produk --}}
        <div class="col-6 col-lg-3">
            <div class="stock-card bg-white shadow-sm border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="stock-icon-circle bg-info-subtle text-info">
                        <i class="fa-solid fa-cubes"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold d-block">Total Produk</span>
                        <h4 class="fw-bold mb-0 text-dark" id="valTotalProduk">{{ $stokSummary['totalProduk'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Aman --}}
        <div class="col-6 col-lg-3">
            <div class="stock-card bg-white shadow-sm border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="stock-icon-circle bg-success-subtle text-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold d-block">Stok Aman (>10)</span>
                        <h4 class="fw-bold mb-0 text-success" id="valStokAman">{{ $stokSummary['stokAman'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Minimum --}}
        <div class="col-6 col-lg-3">
            <div class="stock-card bg-white shadow-sm border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="stock-icon-circle bg-warning-subtle text-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold d-block">Stok Menipis (≤10)</span>
                        <h4 class="fw-bold mb-0 text-warning" id="valStokMinimum">{{ $stokSummary['stokMinimum'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Habis --}}
        <div class="col-6 col-lg-3">
            <div class="stock-card bg-white shadow-sm border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="stock-icon-circle bg-danger-subtle text-danger">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-bold d-block">Stok Habis (0)</span>
                        <h4 class="fw-bold mb-0 text-danger" id="valStokHabis">{{ $stokSummary['stokHabis'] ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Interactive Charts Grid --}}
    <div class="row g-4 mb-4">
        {{-- Tren Penjualan 7 Hari --}}
        <div class="col-lg-8">
            <div class="dashboard-card shadow-sm">
                <div class="dashboard-card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-chart-line text-primary me-2"></i>Tren Penjualan 7 Hari Terakhir</h6>
                        <small class="text-muted">Grafik total omset penjualan harian</small>
                    </div>
                    <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill fw-bold">Mingguan</span>
                </div>
                <div class="dashboard-card-body">
                    <div style="height: 280px;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Komposisi Kas Hari Ini --}}
        <div class="col-lg-4">
            <div class="dashboard-card shadow-sm">
                <div class="dashboard-card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-chart-pie text-success me-2"></i>Komposisi Arus Kas</h6>
                        <small class="text-muted">Perbandingan masuk vs keluar</small>
                    </div>
                    <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">Hari Ini</span>
                </div>
                <div class="dashboard-card-body d-flex flex-column align-items-center justify-content-center">
                    <div style="height: 220px; width: 100%;">
                        <canvas id="grafikKeuangan"></canvas>
                    </div>
                    <div class="d-flex justify-content-around w-100 mt-3 pt-3 border-top text-center">
                        <div>
                            <span class="text-muted small d-block">Masuk</span>
                            <span class="fw-bold text-success">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-end"></div>
                        <div>
                            <span class="text-muted small d-block">Keluar</span>
                            <span class="fw-bold text-danger">Rp {{ number_format($pengeluaranHariIni, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. Low Stock Warning Table & Shortcuts --}}
    <div class="row g-4">
        {{-- Low Stock Table --}}
        <div class="col-lg-8">
            <div class="dashboard-card shadow-sm">
                <div class="dashboard-card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Peringatan Stok Rendah & Perlu Restok</h6>
                        <small class="text-muted">Daftar item dengan stok kurang dari atau sama dengan 10</small>
                    </div>
                    <a href="{{ url('/stok-produk') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        Lihat Semua Stok <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="dashboard-card-body p-0">
                    @if(isset($stokSummary['produkStokRendah']) && count($stokSummary['produkStokRendah']) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">No</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori / Jenis</th>
                                        <th class="text-center">Sisa Stok</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="stokRendahTableBody">
                                    @foreach($stokSummary['produkStokRendah'] as $index => $produk)
                                    <tr data-jenis="{{ $produk['jenis'] }}">
                                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $produk['nm_barang'] }}</div>
                                            <small class="text-muted font-monospace">{{ $produk['kd_barang'] }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $produk['jenis'] == 'Pembelian' ? 'bg-info-subtle text-info' : 'bg-primary-subtle text-primary' }} rounded-pill px-3 py-1">
                                                {{ $produk['jenis'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $produk['stok'] == 0 ? 'bg-danger' : 'bg-warning text-dark' }} rounded-pill px-3 py-1 fw-bold">
                                                {{ $produk['stok'] }} Pcs
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($produk['stok'] == 0)
                                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1">
                                                    <i class="fa-solid fa-circle-xmark me-1"></i> Habis
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-1">
                                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Menipis
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ url('/produk-masuk/create') }}" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Tambah Stok Baru">
                                                <i class="fa-solid fa-plus me-1"></i> Restok
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5" id="stokAmanMessage">
                            <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fa-solid fa-check fs-3"></i>
                            </div>
                            <h6 class="fw-bold text-success mb-1">Semua Stok Barang Aman!</h6>
                            <p class="text-muted small mb-0">Tidak ada produk yang memerlukan restok segera.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Fast Operational Shortcuts --}}
        <div class="col-lg-4">
            <div class="dashboard-card shadow-sm h-100">
                <div class="dashboard-card-header">
                    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-bolt text-warning me-2"></i>Pintasan Operasional Butik</h6>
                    <small class="text-muted">Akses cepat menu utama</small>
                </div>
                <div class="dashboard-card-body">
                    <div class="d-flex flex-column gap-2">
                        
                        <a href="{{ url('/menu-penjualan') }}" class="shortcut-item">
                            <div class="shortcut-icon bg-primary-subtle text-primary">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Transaksi Kasir (POS)</div>
                                <small class="text-muted">Input transaksi penjualan baru</small>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted"></i>
                        </a>

                        <a href="{{ url('/penjualan-barang') }}" class="shortcut-item">
                            <div class="shortcut-icon bg-success-subtle text-success">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Kelola Produk Gamis</div>
                                <small class="text-muted">Katalog harga & stok busana</small>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted"></i>
                        </a>

                        <a href="{{ url('/laporan-penjualan') }}" class="shortcut-item">
                            <div class="shortcut-icon bg-warning-subtle text-warning">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Laporan Penjualan</div>
                                <small class="text-muted">Rekap transaksi & cetak PDF</small>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted"></i>
                        </a>

                        <a href="{{ url('/setting-penjualan') }}" class="shortcut-item">
                            <div class="shortcut-icon bg-info-subtle text-info">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark">Pengaturan PPN & Diskon</div>
                                <small class="text-muted">Atur persentase diskon toko</small>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Enhanced CSS --}}
<style>
    :root {
        --dash-primary: #5f27cd;
        --dash-primary-hover: #481b9e;
        --dash-radius: 18px;
    }

    .dashboard-wrapper {
        padding: 5px 0 30px 0;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #5f27cd 0%, #833ab4 100%);
        border-radius: var(--dash-radius);
        padding: 30px;
        color: #ffffff;
        box-shadow: 0 15px 30px rgba(95, 39, 205, 0.25);
    }
    .user-avatar-box {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .welcome-title {
        font-weight: 800;
        font-size: 1.6rem;
    }

    /* Metric Cards */
    .metric-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 18px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
    }
    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.08);
    }
    .metric-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .metric-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .metric-value {
        font-weight: 800;
        font-size: 1.45rem;
        color: #1e293b;
        margin-bottom: 6px;
        line-height: 1.1;
    }
    .metric-desc {
        font-size: 0.78rem;
        font-weight: 600;
    }
    .metric-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    /* Metric Themes */
    .metric-emerald .metric-icon-circle { background-color: #dcfce7; color: #16a34a; }
    .metric-rose .metric-icon-circle { background-color: #ffe4e6; color: #e11d48; }
    .metric-indigo .metric-icon-circle { background-color: #ede9fe; color: #7c3aed; }
    .metric-amber .metric-icon-circle { background-color: #fef3c7; color: #d97706; }

    /* Stock Status Cards */
    .stock-card {
        padding: 18px 20px;
        border-radius: 16px;
        transition: all 0.25s;
    }
    .stock-card:hover {
        transform: translateY(-3px);
    }
    .stock-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        overflow: hidden;
    }
    .dashboard-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
    }
    .dashboard-card-body {
        padding: 24px;
    }

    /* Shortcut Items */
    .shortcut-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 14px;
        text-decoration: none;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        transition: all 0.25s;
    }
    .shortcut-item:hover {
        background: #ffffff;
        border-color: #f8bbd0;
        box-shadow: 0 6px 16px rgba(155, 27, 74, 0.08);
        transform: translateX(4px);
    }
    .shortcut-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
</style>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const clockElem = document.getElementById('liveClock');
        if (clockElem) {
            clockElem.textContent = `${hours}:${minutes} WIB`;
        }
    }
    setInterval(updateClock, 1000);

    // Chart 1: Penjualan Mingguan (Area Line Chart)
    const ctx = document.getElementById('myChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($chartPenjualan as $data)
                        '{{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('dddd') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Omset Penjualan (Rp)',
                    data: [
                        @foreach($chartPenjualan as $data)
                            {{ $data->total }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(155, 27, 74, 0.08)',
                    borderColor: '#9b1b4a',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.38,
                    pointBackgroundColor: '#9b1b4a',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Total: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(241, 245, 249, 1)' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value >= 1000000 ? (value/1000000) + 'jt' : (value/1000) + 'rb');
                            },
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 12, weight: '500' } }
                    }
                }
            }
        });
    }

    // Chart 2: Komposisi Keuangan (Doughnut Chart)
    const ctx2 = document.getElementById('grafikKeuangan');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Pemasukan Kas', 'Pengeluaran Kas'],
                datasets: [{
                    data: [
                        {{ $pemasukanHariIni > 0 || $pengeluaranHariIni > 0 ? $pemasukanHariIni : 1 }},
                        {{ $pemasukanHariIni > 0 || $pengeluaranHariIni > 0 ? $pengeluaranHariIni : 0 }}
                    ],
                    backgroundColor: ['#10b981', '#f43f5e'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // Refresh Stock Data AJAX
    function refreshStokData() {
        const filter = $('#stokFilter').val();
        $('#valTotalProduk, #valStokAman, #valStokMinimum, #valStokHabis').html('<i class="fa-solid fa-spinner fa-spin text-muted fs-6"></i>');

        $.ajax({
            url: '{{ url("/dashboard/refresh-stok") }}',
            type: 'GET',
            data: { filter: filter },
            success: function(response) {
                $('#valTotalProduk').text(response.totalProduk);
                $('#valStokAman').text(response.stokAman);
                $('#valStokMinimum').text(response.stokMinimum);
                $('#valStokHabis').text(response.stokHabis);

                updateStokRendahTable(response.produkStokRendah);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data stok berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function(err) {
                console.error(err);
                location.reload();
            }
        });
    }

    function updateStokRendahTable(produkList) {
        const tbody = $('#stokRendahTableBody');
        const emptyMsg = $('#stokAmanMessage');

        if (produkList && produkList.length > 0) {
            let html = '';
            produkList.forEach((item, idx) => {
                html += `
                    <tr data-jenis="${item.jenis}">
                        <td class="ps-4 text-muted">${idx + 1}</td>
                        <td>
                            <div class="fw-bold text-dark">${item.nm_barang}</div>
                            <small class="text-muted font-monospace">${item.kd_barang}</small>
                        </td>
                        <td>
                            <span class="badge ${item.jenis === 'Pembelian' ? 'bg-info-subtle text-info' : 'bg-primary-subtle text-primary'} rounded-pill px-3 py-1">
                                ${item.jenis}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge ${item.stok === 0 ? 'bg-danger' : 'bg-warning text-dark'} rounded-pill px-3 py-1 fw-bold">
                                ${item.stok} Pcs
                            </span>
                        </td>
                        <td class="text-center">
                            ${item.stok === 0 
                                ? '<span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1"><i class="fa-solid fa-circle-xmark me-1"></i> Habis</span>'
                                : '<span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Menipis</span>'
                            }
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ url('/produk-masuk/create') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="fa-solid fa-plus me-1"></i> Restok
                            </a>
                        </td>
                    </tr>
                `;
            });
            tbody.html(html);
            tbody.closest('.table-responsive').show();
            emptyMsg.hide();
        } else {
            tbody.closest('.table-responsive').hide();
            emptyMsg.show();
        }
    }

    $('#stokFilter').on('change', function() {
        refreshStokData();
    });

    // Logout Confirmation Modal
    function confirmLogout() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#9b1b4a',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Logout Sekarang',
                cancelButtonText: 'Batal',
                borderRadius: '16px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
@endpush