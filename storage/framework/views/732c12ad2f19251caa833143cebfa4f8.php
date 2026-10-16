

<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-purple: #5f27cd;
        --primary-purple-hover: #481b9e;
        --purple-soft: #f3f0fb;
        --purple-border: #e9e3f8;
    }

    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-title-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ede7f6;
        color: #5f27cd;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 8px;
    }
    .page-main-title {
        font-weight: 800;
        font-size: 1.65rem;
        color: #1e293b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    /* KPI Stat Cards */
    .stat-kpi-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 22px;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .stat-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(95, 39, 205, 0.08);
        border-color: var(--purple-border);
    }
    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 14px;
    }
    .stat-kpi-val {
        font-size: 1.65rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }
    .stat-kpi-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .stat-kpi-subtext {
        font-size: 0.75rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Color variations */
    .kpi-red .stat-icon-wrapper { background: #fee2e2; color: #dc2626; }
    .kpi-red .stat-kpi-val { color: #dc2626; }

    .kpi-green .stat-icon-wrapper { background: #dcfce7; color: #16a34a; }
    .kpi-green .stat-kpi-val { color: #16a34a; }

    .kpi-indigo .stat-icon-wrapper { background: #e0e7ff; color: #4f46e5; }
    .kpi-indigo .stat-kpi-val { color: #4f46e5; }

    .kpi-purple .stat-icon-wrapper { background: #f3f0fb; color: #5f27cd; }
    .kpi-purple .stat-kpi-val { color: #5f27cd; }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        padding: 20px 24px;
        margin-bottom: 24px;
    }
    .form-label-custom {
        font-size: 0.82rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }
    .input-date-custom {
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        padding: 8px 14px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #1e293b;
    }
    .input-date-custom:focus {
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 3px rgba(95, 39, 205, 0.12);
    }
    .preset-pill-btn {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 50px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .preset-pill-btn:hover, .preset-pill-btn.active {
        background: #5f27cd;
        color: #ffffff;
        border-color: #5f27cd;
    }

    /* Interpretation Alert Banner */
    .smart-interpretation-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        border-left: 5px solid #5f27cd;
        padding: 18px 22px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 24px;
        margin-bottom: 24px;
    }
    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Pill Badges inside table */
    .pill-currency-red {
        display: inline-block;
        background: #fee2e2;
        color: #b91c1c;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 30px;
    }
    .pill-currency-green {
        display: inline-block;
        background: #dcfce7;
        color: #15803d;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 30px;
    }
    .pill-currency-blue {
        display: inline-block;
        background: #e0e7ff;
        color: #4338ca;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 30px;
    }
    .pill-currency-orange {
        display: inline-block;
        background: #fef3c7;
        color: #b45309;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 30px;
    }

    /* Table Headers & Rows */
    #table_id th {
        background-color: #f8fafc;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 12px;
        border-bottom: 2px solid #e2e8f0;
    }
    #table_id td {
        padding: 14px 12px;
        vertical-align: middle;
        font-size: 0.88rem;
        border-bottom: 1px solid #f1f5f9;
    }
    #table_id tbody tr:hover {
        background-color: #fcfaff;
    }

    /* Action Buttons */
    .btn-print-pdf {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        border-radius: 12px;
        padding: 10px 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-print-pdf:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: #ffffff;
        transform: translateY(-1px);
    }
    .btn-purple-action {
        background: linear-gradient(135deg, #6c5ce7 0%, #5f27cd 100%);
        border: none;
        color: #ffffff;
        font-weight: 700;
        border-radius: 12px;
        padding: 9px 18px;
        box-shadow: 0 4px 12px rgba(95, 39, 205, 0.25);
        transition: all 0.2s;
    }
    .btn-purple-action:hover {
        background: linear-gradient(135deg, #5844e0 0%, #481b9e 100%);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Accordion Guide */
    .accordion-guide .accordion-button {
        border-radius: 16px !important;
        font-weight: 700;
        background: #f8fafc;
        color: #334155;
        font-size: 0.92rem;
    }
    .accordion-guide .accordion-button:not(.collapsed) {
        background: var(--purple-soft);
        color: var(--primary-purple);
    }
</style>

<div class="container-fluid px-4 py-3">

    <!-- Page Header & Action Toolbar -->
    <div class="page-header-box">
        <div>
            <div class="page-title-badge">
                <i class="fa-solid fa-receipt"></i> Sansin POS &bull; Pajak Pertambahan Nilai
            </div>
            <h1 class="page-main-title">
                <i class="fa-solid fa-calculator text-primary"></i>
                <span>Laporan PPN Keseluruhan</span>
            </h1>
            <p class="page-subtitle">Rekapitulasi Pajak Masukan (Pembelian) vs Pajak Keluaran (Penjualan) Sesuai Ketentuan UU HPP (Tarif PPN 11%)</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold" id="refresh_btn" title="Muat ulang seluruh data">
                <i class="fa-solid fa-arrows-rotate me-1"></i> Refresh Data
            </button>
            <a href="javascript:void(0)" class="btn-print-pdf" id="print-laporan-ppn" title="Unduh Cetak PDF Laporan Resmi">
                <i class="fa-solid fa-file-pdf"></i> Cetak Laporan PDF
            </a>
        </div>
    </div>

    <!-- 4 KPI Stat Metric Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: PPN Pengeluaran -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-kpi-card kpi-red">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper">
                            <i class="fa-solid fa-arrow-trend-down"></i>
                        </div>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill small fw-bold">Pajak Pembelian</span>
                    </div>
                    <div class="stat-kpi-label">Total PPN Pengeluaran</div>
                    <div class="stat-kpi-val" id="total-ppn-pengeluaran-summary">Rp 0</div>
                </div>
                <div class="stat-kpi-subtext mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i> 11% dari pembelian / biaya masuk
                </div>
            </div>
        </div>

        <!-- Card 2: PPN Pemasukan -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-kpi-card kpi-green">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill small fw-bold">Pajak Penjualan</span>
                    </div>
                    <div class="stat-kpi-label">Total PPN Pemasukan</div>
                    <div class="stat-kpi-val" id="total-ppn-pemasukan-summary">Rp 0</div>
                </div>
                <div class="stat-kpi-subtext mt-2">
                    <i class="fa-solid fa-circle-info me-1"></i> 11% dari penjualan / pendapatan
                </div>
            </div>
        </div>

        <!-- Card 3: Total Selisih PPN -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-kpi-card kpi-indigo" id="selisih-kpi-card">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill small fw-bold" id="badge-selisih-type">Selisih Bersih</span>
                    </div>
                    <div class="stat-kpi-label">Total Selisih PPN</div>
                    <div class="stat-kpi-val" id="total-selisih-summary">Rp 0</div>
                </div>
                <div class="stat-kpi-subtext mt-2">
                    <i class="fa-solid fa-calculator me-1"></i> PPN Pengeluaran - Pemasukan
                </div>
            </div>
        </div>

        <!-- Card 4: PPN yang Harus Disetor -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-kpi-card kpi-purple">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <span class="badge bg-purple-soft text-purple border px-2 py-1 rounded-pill small fw-bold">Kas Negara</span>
                    </div>
                    <div class="stat-kpi-label">PPN Wajib Disetor</div>
                    <div class="stat-kpi-val" id="ppn-harus-dibayar-summary">Rp 0</div>
                </div>
                <div class="stat-kpi-subtext mt-2">
                    <i class="fa-solid fa-shield-halved me-1"></i> Kewajiban bayar jika selisih (+)
                </div>
            </div>
        </div>
    </div>

    <!-- Smart Tax Interpretation Alert Box -->
    <div class="smart-interpretation-card" id="interpretation-box">
        <div class="d-flex align-items-start gap-3">
            <div class="flex-shrink-0 mt-1" id="interpretation-icon">
                <i class="fa-solid fa-circle-info fs-3 text-primary"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h6 class="fw-bold mb-0 text-dark">Interpretasi Fiskal & Kewajiban Pajak</h6>
                    <span class="badge px-3 py-1 rounded-pill small fw-bold" id="interpretation-badge">Memuat...</span>
                </div>
                <div class="small text-secondary" id="interpretation-detail">
                    Sedang memuat dan menganalisis rekapitulasi data transaksi PPN...
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card Toolbar -->
    <div class="filter-card">
        <form id="filter_form" action="/laporan-ppn-keseluruhan/get-data" method="GET">
            <div class="row align-items-end g-3">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label-custom"><i class="fa-regular fa-calendar me-1 text-primary"></i> Tanggal Mulai Transaksi</label>
                    <input type="date" class="form-control input-date-custom" name="tanggal_mulai" id="tanggal_mulai">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="form-label-custom"><i class="fa-regular fa-calendar-check me-1 text-primary"></i> Tanggal Selesai Transaksi</label>
                    <input type="date" class="form-control input-date-custom" name="tanggal_selesai" id="tanggal_selesai">
                </div>
                <div class="col-lg-4 col-md-12 d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-purple-action flex-fill">
                        <i class="fa-solid fa-filter me-1"></i> Terapkan Filter
                    </button>
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold" onclick="resetDateFilter()">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </button>
                </div>
            </div>

            <!-- Quick Preset Date Pills -->
            <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top flex-wrap">
                <span class="text-muted small fw-bold me-1"><i class="fa-solid fa-bolt text-warning me-1"></i> Preset Cepat:</span>
                <button type="button" class="preset-pill-btn active" onclick="setPresetDate('all', this)">Semua Data</button>
                <button type="button" class="preset-pill-btn" onclick="setPresetDate('this_month', this)">Bulan Ini</button>
                <button type="button" class="preset-pill-btn" onclick="setPresetDate('last_7_days', this)">7 Hari Terakhir</button>
                <button type="button" class="preset-pill-btn" onclick="setPresetDate('last_30_days', this)">30 Hari Terakhir</button>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <div>
                <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-table-list text-primary me-2"></i>Tabel Rincian PPN Harian</h5>
                <p class="text-muted small mb-0">Daftar akumulasi PPN Pengeluaran, PPN Pemasukan, dan Selisih per tanggal transaksi</p>
            </div>
            <div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold" id="table-row-counter">
                    <i class="fa-solid fa-layer-group text-primary me-1"></i> Memuat baris...
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table id="table_id" class="table table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th class="text-center" style="width: 140px;">Tanggal Transaksi</th>
                        <th class="text-end">PPN Pengeluaran (11%)</th>
                        <th class="text-end">PPN Pemasukan (11%)</th>
                        <th class="text-end">Selisih PPN</th>
                        <th class="text-center" style="width: 190px;">Status Pajak</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr style="background-color: #f8fafc; font-weight: 800;">
                        <td colspan="2" class="text-center py-3">TOTAL KESELURUHAN</td>
                        <td class="text-end py-3" id="tfoot-pengeluaran">Rp 0</td>
                        <td class="text-end py-3" id="tfoot-pemasukan">Rp 0</td>
                        <td class="text-end py-3" id="tfoot-selisih">Rp 0</td>
                        <td class="text-center py-3" id="tfoot-status">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Information & Guide Accordion -->
    <div class="accordion accordion-guide mb-4" id="taxGuideAccordion">
        <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTaxGuide">
                    <i class="fa-solid fa-circle-question me-2 text-primary"></i> Panduan & Formula Perhitungan PPN Sesuai UU HPP (Tarif 11%)
                </button>
            </h2>
            <div id="collapseTaxGuide" class="accordion-collapse collapse" data-bs-parent="#taxGuideAccordion">
                <div class="accordion-body bg-white p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-calculator text-primary me-2"></i>Rumus Perhitungan:</h6>
                            <ul class="text-secondary small mb-0 ps-3">
                                <li class="mb-2"><strong>PPN Pengeluaran (Pajak Masukan Pembelian):</strong> Dihitung sebesar 11% dari total nilai pembelian barang/jasa atau produk keluar dari gudang.</li>
                                <li class="mb-2"><strong>PPN Pemasukan (Pajak Keluaran Penjualan):</strong> Dihitung sebesar 11% dari total harga produk masuk / pendapatan transaksi.</li>
                                <li><strong>Selisih PPN = PPN Pengeluaran &minus; PPN Pemasukan</strong></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-scale-balanced text-success me-2"></i>Ketentuan Status Fiskal:</h6>
                            <ul class="text-secondary small mb-0 ps-3">
                                <li class="mb-2"><span class="badge bg-danger-subtle text-danger fw-bold">Kurang Bayar:</span> Jika Selisih Positif (+), PPN Pengeluaran > PPN Pemasukan, perusahaan wajib menyetorkan kekurangan pajak ke kas negara.</li>
                                <li class="mb-2"><span class="badge bg-success-subtle text-success fw-bold">Lebih Bayar:</span> Jika Selisih Negatif (&minus;), PPN Pemasukan > PPN Pengeluaran, perusahaan berhak atas restitusi pajak atau kompensasi ke masa berikutnya.</li>
                                <li><span class="badge bg-secondary-subtle text-secondary fw-bold">Nihil:</span> Jika Selisih = 0, posisi pajak seimbang.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- DataTables & Interactive Logic -->
<script>
    let dataTableInstance = null;

    $(document).ready(function() {
        // Initialize DataTable
        dataTableInstance = $('#table_id').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "order": [[1, "desc"]],
            "pageLength": 10,
            "autoWidth": false
        });

        // Load initial data
        loadData();

        // Filter Form submit
        $('#filter_form').submit(function(e) {
            e.preventDefault();
            loadData();
        });

        // Refresh Button
        $('#refresh_btn').on('click', function() {
            resetDateFilter();
        });

        // Print PDF Button
        $('#print-laporan-ppn').on('click', function() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();
            var url = '/laporan-ppn-keseluruhan/print-ppn-keseluruhan';
            if (tanggalMulai && tanggalSelesai) {
                url += '?tanggal_mulai=' + tanggalMulai + '&tanggal_selesai=' + tanggalSelesai;
            }
            window.location.href = url;
        });
    });

    const formatRupiah = function(amount) {
        if (amount == 0 || amount == null) return 'Rp 0';
        return 'Rp ' + parseFloat(amount).toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    };

    const formatDate = function(dateString) {
        if (!dateString) return '-';
        try {
            let date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        } catch (e) {
            return dateString;
        }
    };

    const updateInterpretation = function(totalPengeluaran, totalPemasukan, totalSelisih) {
        let box = $('#interpretation-box');
        let icon = $('#interpretation-icon');
        let badge = $('#interpretation-badge');
        let detail = $('#interpretation-detail');

        if (totalSelisih > 0) {
            // Positif = Perusahaan bayar ke negara
            box.css('border-left-color', '#e11d48');
            icon.html('<i class="fa-solid fa-triangle-exclamation fs-3 text-danger"></i>');
            badge.removeClass().addClass('badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill small fw-bold').text('Status: Kurang Bayar (Wajib Setor)');
            detail.html(`
                Perusahaan memiliki kewajiban menyetorkan PPN ke Kas Negara sebesar <strong>${formatRupiah(totalSelisih)}</strong> karena akumulasi <strong>PPN Pengeluaran (${formatRupiah(totalPengeluaran)})</strong> lebih besar daripada <strong>PPN Pemasukan (${formatRupiah(totalPemasukan)})</strong> pada periode yang dipilih.
            `);
        } else if (totalSelisih < 0) {
            // Negatif = Hak restitusi
            let absSelisih = Math.abs(totalSelisih);
            box.css('border-left-color', '#10b981');
            icon.html('<i class="fa-solid fa-circle-check fs-3 text-success"></i>');
            badge.removeClass().addClass('badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill small fw-bold').text('Status: Lebih Bayar (Hak Restitusi)');
            detail.html(`
                Perusahaan berhak memperoleh <strong>Restitusi Pengembalian Pajak</strong> atau kompensasi masa pajak berikutnya sebesar <strong>${formatRupiah(absSelisih)}</strong> dari negara, dikarenakan <strong>PPN Pemasukan (${formatRupiah(totalPemasukan)})</strong> lebih tinggi daripada <strong>PPN Pengeluaran (${formatRupiah(totalPengeluaran)})</strong>.
            `);
        } else {
            // Seimbang
            box.css('border-left-color', '#6366f1');
            icon.html('<i class="fa-solid fa-scale-balanced fs-3 text-primary"></i>');
            badge.removeClass().addClass('badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill small fw-bold').text('Status: Seimbang (Nihil)');
            detail.html(`
                Akumulasi PPN Pengeluaran dan PPN Pemasukan dalam keadaan seimbang (Nihil), sehingga tidak terdapat kewajiban setor maupun hak restitusi pajak untuk periode ini.
            `);
        }
    };

    const loadPPNKeluar = function(tanggalMulai, tanggalSelesai) {
        return $.ajax({
            url: '/laporan-produk-keluar/get-data',
            type: "GET",
            dataType: 'JSON',
            data: { tanggal_mulai: tanggalMulai, tanggal_selesai: tanggalSelesai }
        });
    };

    const loadPPNMasuk = function(tanggalMulai, tanggalSelesai) {
        return $.ajax({
            url: '/laporan-produk-masuk/get-data',
            type: "GET",
            dataType: 'JSON',
            data: { tanggal_mulai: tanggalMulai, tanggal_selesai: tanggalSelesai }
        });
    };

    const processAndDisplayData = function(ppnKeluarData, ppnMasukData) {
        let dateGroups = {};

        // Process PPN Keluar (Pengeluaran = 11% dari total_harga atau harga_beli)
        if (ppnKeluarData && ppnKeluarData.length > 0) {
            $.each(ppnKeluarData, function(key, value) {
                let tanggal = value.tgl_keluar;
                if (!tanggal) return;
                if (!dateGroups[tanggal]) {
                    dateGroups[tanggal] = { ppn_pengeluaran: 0, ppn_pemasukan: 0 };
                }
                let amountKeluar = (parseFloat(value.total_harga) > 0 ? parseFloat(value.total_harga) : parseFloat(value.harga_beli)) || 0;
                dateGroups[tanggal].ppn_pengeluaran += (amountKeluar * 0.11);
            });
        }

        // Process PPN Masuk (Pemasukan = 11% dari total_harga)
        if (ppnMasukData && ppnMasukData.length > 0) {
            $.each(ppnMasukData, function(key, value) {
                let tanggal = value.tgl_masuk;
                if (!tanggal) return;
                if (!dateGroups[tanggal]) {
                    dateGroups[tanggal] = { ppn_pengeluaran: 0, ppn_pemasukan: 0 };
                }
                let amountMasuk = (parseFloat(value.total_harga) || 0);
                dateGroups[tanggal].ppn_pemasukan += (amountMasuk * 0.11);
            });
        }

        dataTableInstance.clear();
        let sortedDates = Object.keys(dateGroups).sort().reverse(); // Sort descending
        let totalPPNPengeluaran = 0;
        let totalPPNPemasukan = 0;
        let totalSelisih = 0;

        if (sortedDates.length === 0) {
            $('#table-row-counter').html('<i class="fa-solid fa-circle-exclamation text-danger me-1"></i> 0 Data Transaksi');
            $('#total-ppn-pengeluaran-summary').text('Rp 0');
            $('#total-ppn-pemasukan-summary').text('Rp 0');
            $('#total-selisih-summary').text('Rp 0');
            $('#ppn-harus-dibayar-summary').text('Rp 0');
            updateInterpretation(0, 0, 0);
            dataTableInstance.draw();
            return;
        }

        $('#table-row-counter').html(`<i class="fa-solid fa-layer-group text-primary me-1"></i> ${sortedDates.length} Hari Transaksi`);

        let counter = 1;
        $.each(sortedDates, function(index, tanggal) {
            let item = dateGroups[tanggal];
            let selisih = item.ppn_pengeluaran - item.ppn_pemasukan;

            totalPPNPengeluaran += item.ppn_pengeluaran;
            totalPPNPemasukan += item.ppn_pemasukan;
            totalSelisih += selisih;

            // Status Badge
            let statusBadge = '';
            let selisihPill = '';
            if (selisih > 0) {
                statusBadge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1"><i class="fa-solid fa-arrow-up me-1"></i> Kurang Bayar</span>';
                selisihPill = `<span class="pill-currency-red">+${formatRupiah(selisih)}</span>`;
            } else if (selisih < 0) {
                statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1"><i class="fa-solid fa-arrow-down me-1"></i> Lebih Bayar</span>';
                selisihPill = `<span class="pill-currency-green">${formatRupiah(selisih)}</span>`;
            } else {
                statusBadge = '<span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3 py-1"><i class="fa-solid fa-check me-1"></i> Seimbang</span>';
                selisihPill = `<span class="pill-currency-blue">${formatRupiah(0)}</span>`;
            }

            let rowHtml = `
                <tr>
                    <td class="text-center text-muted fw-bold">${counter++}</td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-semibold">
                            <i class="fa-regular fa-calendar me-1 text-primary"></i> ${formatDate(tanggal)}
                        </span>
                    </td>
                    <td class="text-end"><span class="pill-currency-red">${formatRupiah(item.ppn_pengeluaran)}</span></td>
                    <td class="text-end"><span class="pill-currency-green">${formatRupiah(item.ppn_pemasukan)}</span></td>
                    <td class="text-end">${selisihPill}</td>
                    <td class="text-center">${statusBadge}</td>
                </tr>
            `;
            dataTableInstance.row.add($(rowHtml));
        });

        dataTableInstance.draw(false);

        // Update Summary Cards
        $('#total-ppn-pengeluaran-summary').text(formatRupiah(totalPPNPengeluaran));
        $('#total-ppn-pemasukan-summary').text(formatRupiah(totalPPNPemasukan));
        
        let selisihText = (totalSelisih > 0 ? '+' : '') + formatRupiah(totalSelisih);
        $('#total-selisih-summary').text(selisihText);

        let ppnHarusDibayar = Math.max(0, totalSelisih);
        $('#ppn-harus-dibayar-summary').text(formatRupiah(ppnHarusDibayar));

        // Update Table Footers
        $('#tfoot-pengeluaran').html(`<span class="pill-currency-red">${formatRupiah(totalPPNPengeluaran)}</span>`);
        $('#tfoot-pemasukan').html(`<span class="pill-currency-green">${formatRupiah(totalPPNPemasukan)}</span>`);
        $('#tfoot-selisih').html(`<span class="${totalSelisih >= 0 ? 'pill-currency-red' : 'pill-currency-green'}">${selisihText}</span>`);
        $('#tfoot-status').html(totalSelisih > 0 ? '<span class="badge bg-danger text-white rounded-pill px-3 py-1">Kurang Bayar</span>' : '<span class="badge bg-success text-white rounded-pill px-3 py-1">Lebih Bayar</span>');

        // Update Interpretation
        updateInterpretation(totalPPNPengeluaran, totalPPNPemasukan, totalSelisih);
    };

    const loadData = function() {
        var tanggalMulai = $('#tanggal_mulai').val();
        var tanggalSelesai = $('#tanggal_selesai').val();

        Promise.all([
            loadPPNKeluar(tanggalMulai, tanggalSelesai),
            loadPPNMasuk(tanggalMulai, tanggalSelesai)
        ]).then(function([ppnKeluarData, ppnMasukData]) {
            processAndDisplayData(ppnKeluarData, ppnMasukData);
        }).catch(function(error) {
            console.error('Error loading PPN data:', error);
            $('#table-row-counter').html('<i class="fa-solid fa-triangle-exclamation text-danger me-1"></i> Gagal Memuat Data');
        });
    };

    const resetDateFilter = function() {
        $('#filter_form')[0].reset();
        $('.preset-pill-btn').removeClass('active');
        $('.preset-pill-btn').first().addClass('active');
        loadData();
    };

    const setPresetDate = function(preset, element) {
        $('.preset-pill-btn').removeClass('active');
        $(element).addClass('active');

        let now = new Date();
        let startDate = '';
        let endDate = now.toISOString().split('T')[0];

        if (preset === 'this_month') {
            let firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            startDate = firstDay.toISOString().split('T')[0];
        } else if (preset === 'last_7_days') {
            let d = new Date();
            d.setDate(d.getDate() - 7);
            startDate = d.toISOString().split('T')[0];
        } else if (preset === 'last_30_days') {
            let d = new Date();
            d.setDate(d.getDate() - 30);
            startDate = d.toISOString().split('T')[0];
        } else {
            // 'all'
            startDate = '';
            endDate = '';
        }

        $('#tanggal_mulai').val(startDate);
        $('#tanggal_selesai').val(endDate);
        loadData();
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\App-Penjualan\resources\views/laporan-ppn-keseluruhan/index.blade.php ENDPATH**/ ?>