<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Sansin Indonesia</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #5f27cd;
            --primary-light: #f3f0fb;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            padding-bottom: 60px;
        }
        .navbar-custom {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 0;
        }
        .navbar-brand-logo {
            font-weight: 800;
            font-size: 1.45rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand-logo i {
            font-size: 1.55rem;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .portal-nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.92rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .portal-nav-link:hover {
            color: var(--primary);
            background-color: var(--primary-light);
        }
        .portal-nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #6c5ce7, #5f27cd);
            box-shadow: 0 4px 12px rgba(95, 39, 205, 0.25);
        }
        .order-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            padding: 20px;
            margin-bottom: 18px;
            transition: all 0.2s;
        }
        .order-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }
        .nav-pills .nav-link {
            color: #64748b;
            font-weight: 600;
            border-radius: 30px;
            padding: 8px 18px;
            margin-right: 6px;
        }
        .nav-pills .nav-link.active {
            background-color: var(--primary);
            color: white;
        }

        /* Tokopedia-Style Tracking Timeline */
        .tracking-timeline {
            position: relative;
            padding-left: 32px;
        }
        .tracking-timeline::before {
            content: '';
            position: absolute;
            top: 12px;
            bottom: 12px;
            left: 11px;
            width: 2px;
            background: #e2e8f0;
        }
        .tracking-step {
            position: relative;
            padding-bottom: 22px;
        }
        .tracking-step:last-child {
            padding-bottom: 0;
        }
        .tracking-dot {
            position: absolute;
            left: -32px;
            top: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            background: #fff;
            border: 2px solid #cbd5e1;
            color: #94a3b8;
            z-index: 2;
        }
        .tracking-step.completed .tracking-dot {
            background: #03ac0e;
            border-color: #03ac0e;
            color: #fff;
        }
        .tracking-step.current .tracking-dot {
            background: #0284c7;
            border-color: #0284c7;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.2);
            animation: pulse-ring 2s infinite;
        }
        .tracking-step.pending .tracking-dot {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #cbd5e1;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.5); }
            70% { box-shadow: 0 0 0 8px rgba(2, 132, 199, 0); }
            100% { box-shadow: 0 0 0 0 rgba(2, 132, 199, 0); }
        }
        .tracking-time {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 600;
        }
        .tracking-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 1px;
        }
        .tracking-step.current .tracking-title {
            color: #0284c7;
        }
        .tracking-step.completed .tracking-title {
            color: #1e293b;
        }
        .tracking-desc {
            font-size: 0.85rem;
            color: #475569;
            margin-top: 4px;
            line-height: 1.45;
        }
        .tracking-location {
            display: inline-block;
            font-size: 0.75rem;
            background: #f1f5f9;
            color: #475569;
            padding: 2px 8px;
            border-radius: 6px;
            margin-top: 4px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Top Navbar with 3 Dedicated Customer Portals: Beranda (Katalog), Status Pesanan, Profil -->
    <header class="navbar-custom sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand-logo" href="<?php echo e(url('/')); ?>">
                <i class="fa-solid fa-gem"></i>
                <span>Sansin <span style="color:#e65100;">Indonesia</span></span>
            </a>

            <!-- Central Navigation Menu (Beranda, Status Pesanan, Profile) -->
            <nav class="d-none d-md-flex align-items-center gap-2">
                <a href="<?php echo e(url('/')); ?>" class="portal-nav-link">
                    <i class="fa-solid fa-store"></i> Beranda (Katalog)
                </a>
                <a href="<?php echo e(route('customer.pesanan')); ?>" class="portal-nav-link active">
                    <i class="fa-solid fa-box-archive"></i> Status Pesanan
                </a>
                <a href="<?php echo e(route('customer.profile')); ?>" class="portal-nav-link">
                    <i class="fa-solid fa-user-gear"></i> Profil Saya
                </a>
            </nav>

            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-light rounded-pill px-3 py-1 btn-sm fw-semibold dropdown-toggle d-flex align-items-center gap-2 border" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-circle-user text-primary fs-5"></i>
                        <span class="d-none d-sm-inline"><?php echo e(strtok(Auth::user()->name, ' ')); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-2">
                        <li class="px-3 py-1 text-muted small border-bottom mb-1">
                            Akun: <strong><?php echo e(Auth::user()->email); ?></strong>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-md-none" href="<?php echo e(url('/')); ?>">
                                <i class="fa-solid fa-store me-2 text-secondary"></i> Beranda (Katalog)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-md-none active" href="<?php echo e(route('customer.pesanan')); ?>">
                                <i class="fa-solid fa-box-archive me-2 text-primary"></i> Status Pesanan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-md-none" href="<?php echo e(route('customer.profile')); ?>">
                                <i class="fa-solid fa-user-gear me-2 text-primary"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="<?php echo e(route('customer.profile')); ?>">
                                <i class="fa-solid fa-id-card me-2 text-primary"></i> Pengaturan Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-none d-sm-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sub-Navbar for Mobile (Shows 3 main tabs horizontally) -->
    <div class="bg-white border-bottom py-2 d-md-none">
        <div class="container d-flex justify-content-around">
            <a href="<?php echo e(url('/')); ?>" class="portal-nav-link text-center px-2 py-1" style="font-size: 0.82rem;">
                <i class="fa-solid fa-store"></i> Beranda
            </a>
            <a href="<?php echo e(route('customer.pesanan')); ?>" class="portal-nav-link active text-center px-2 py-1" style="font-size: 0.82rem;">
                <i class="fa-solid fa-box-archive"></i> Status Pesanan
            </a>
            <a href="<?php echo e(route('customer.profile')); ?>" class="portal-nav-link text-center px-2 py-1" style="font-size: 0.82rem;">
                <i class="fa-solid fa-user-gear"></i> Profil
            </a>
        </div>
    </div>

    <div class="container mt-4">
        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo e(session('warning')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary px-3 py-1 rounded-pill small fw-bold"><i class="fa-solid fa-circle-user me-1"></i> Dashboard Pelanggan</span>
                </div>
                <h4 class="fw-bold mb-1"><i class="fa-solid fa-box-archive me-2 text-primary"></i>Riwayat Pesanan Saya</h4>
                <p class="text-muted small mb-0">Pantau status pembayaran, proses pengemasan, dan pelacakan kurir paket Anda</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-pills my-3 pb-2 border-bottom flex-nowrap overflow-x-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'semua' ? 'active' : ''); ?>" href="<?php echo e(route('customer.pesanan', ['status' => 'semua'])); ?>">
                    Semua (<?php echo e($countSemua); ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'menunggu_pembayaran' ? 'active' : ''); ?>" href="<?php echo e(route('customer.pesanan', ['status' => 'menunggu_pembayaran'])); ?>">
                    Menunggu Pembayaran (<?php echo e($countMenunggu); ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'diproses' ? 'active' : ''); ?>" href="<?php echo e(route('customer.pesanan', ['status' => 'diproses'])); ?>">
                    Sedang Dikemas (<?php echo e($countDiproses); ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'dikirim' ? 'active' : ''); ?>" href="<?php echo e(route('customer.pesanan', ['status' => 'dikirim'])); ?>">
                    Sedang Dikirim (<?php echo e($countDikirim); ?>)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status === 'selesai' ? 'active' : ''); ?>" href="<?php echo e(route('customer.pesanan', ['status' => 'selesai'])); ?>">
                    Selesai (<?php echo e($countSelesai); ?>)
                </a>
            </li>
        </ul>

        <!-- Orders List -->
        <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="order-card">
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-3 mb-3 border-bottom gap-2">
                    <div>
                        <span class="fw-bold text-dark fs-6"><?php echo e($order->no_pesanan); ?></span>
                        <span class="text-muted small ms-2"><i class="fa-regular fa-calendar me-1"></i><?php echo e($order->created_at->format('d M Y, H:i')); ?></span>
                    </div>
                    <div><?php echo $order->status_badge; ?></div>
                </div>

                <!-- Products in this order -->
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <?php $__currentLoopData = $order->detailPesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="bg-light p-2 rounded text-primary text-center" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-shirt"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?php echo e($item->nm_barang); ?></div>
                                    <div class="small text-muted"><?php echo e($item->jumlah); ?> x <?php echo e($item->formatted_harga_satuan); ?></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="small text-muted mt-2">
                            <i class="fa-solid fa-location-dot text-secondary me-1"></i> Tujuan: <strong><?php echo e($order->kota); ?></strong><?php echo e($order->kecamatan ? ' (Kec. ' . $order->kecamatan . ')' : ''); ?> | Kurir: <strong><?php echo e($order->ekspedisi); ?></strong> (<?php echo e($order->layanan_ekspedisi); ?>)
                            <?php if($order->no_resi): ?>
                                | No. Resi: <strong class="text-primary"><?php echo e($order->no_resi); ?></strong>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-5 text-md-end mt-3 mt-md-0 pt-3 pt-md-0 border-top border-md-top-0">
                        <div class="small text-muted">Total Pembayaran:</div>
                        <div class="fw-bold fs-4 text-primary mb-3"><?php echo e($order->formatted_total_bayar); ?></div>

                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" onclick="openTrackingModal(<?php echo e($order->id); ?>)">
                                <i class="fa-solid fa-truck-fast me-1"></i> Lacak Paket
                            </button>

                            <a href="<?php echo e(route('checkout.success', ['no_pesanan' => $order->no_pesanan])); ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
                                <i class="fa-solid fa-file-invoice me-1"></i> Invoice
                            </a>

                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Sansin%20Indonesia,%20saya%20ingin%20cek%20status%20pesanan%20saya%20<?php echo e($order->no_pesanan); ?>." target="_blank" class="btn btn-outline-success btn-sm rounded-pill">
                                <i class="fa-brands fa-whatsapp me-1"></i> WA Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open fs-1 text-muted mb-3 opacity-50"></i>
                <h5 class="fw-bold text-secondary">Belum ada pesanan pada kategori ini</h5>
                <p class="text-muted small mb-3">Jelajahi koleksi gamis & abaya premium kami dan lakukan pemesanan sekarang.</p>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-primary rounded-pill px-4" style="background-color: var(--primary); border: none;">
                    <i class="fa-solid fa-store me-2"></i> Belanja Sekarang
                </a>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <?php echo e($pesanans->links()); ?>

        </div>
    </div>

    <!-- Modal Tracking Pengiriman (Tokopedia Style) -->
    <div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom py-3 px-4 bg-light rounded-top-4">
                    <div>
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2 mb-0" id="trackingModalLabel">
                            <i class="fa-solid fa-truck-fast text-success"></i>
                            <span>Lacak Pengiriman Kurir</span>
                        </h5>
                        <div class="small text-muted" id="trackOrderNo">Memuat data...</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4" id="trackingModalBody">
                    <!-- Loading State -->
                    <div id="trackingLoading" class="text-center py-5">
                        <div class="spinner-border text-success mb-2" role="status"></div>
                        <div class="text-muted small">Menghubungkan ke sistem tracking kurir...</div>
                    </div>

                    <!-- Content when loaded -->
                    <div id="trackingContent" style="display: none;">
                        <!-- Courier Info Card -->
                        <div class="p-3 rounded-3 border bg-light mb-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-success px-3 py-2 fw-bold fs-6" id="trackCourierBadge">JNE</span>
                                        <div>
                                            <div class="fw-bold text-dark" id="trackCourierService">JNE REG (Reguler)</div>
                                            <div class="small text-muted" id="trackCourierEtd">Estimasi Tiba: 1-3 Hari</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <div class="small text-muted mb-1">Nomor Resi Pengiriman:</div>
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <span class="fw-bold text-primary font-monospace fs-5" id="trackResiText">-</span>
                                        <button type="button" class="btn btn-outline-secondary btn-sm py-1 px-2" id="btnCopyResi" onclick="copyResi()" title="Salin No Resi">
                                            <i class="fa-regular fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2 text-muted opacity-25">
                            <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 small text-muted">
                                <div><i class="fa-solid fa-location-dot me-1 text-danger"></i> <span id="trackRecipient">Penerima: -</span></div>
                                <div id="trackOrderStatusBadge">-</div>
                            </div>
                        </div>

                        <!-- Tokopedia Style Timeline Stepper -->
                        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-route me-2 text-primary"></i>Riwayat Perjalanan Paket</h6>
                        <div class="tracking-timeline" id="trackingTimelineContainer">
                            <!-- Populated dynamically via JS -->
                        </div>

                        <!-- Action links -->
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="small text-muted"><i class="fa-solid fa-shield-halved text-success me-1"></i> Pengiriman resmi terverifikasi</span>
                            <div class="d-flex gap-2">
                                <a href="#" id="trackOfficialLink" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Cek di Web Kurir
                                </a>
                                <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentTrackingResi = '';

        async function openTrackingModal(orderId) {
            const modalEl = document.getElementById('trackingModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            document.getElementById('trackingLoading').style.display = 'block';
            document.getElementById('trackingContent').style.display = 'none';

            try {
                const res = await fetch(`<?php echo e(url('/pesanan-saya')); ?>/${orderId}/tracking`);
                const data = await res.json();

                if (data.success && data.order) {
                    renderTrackingData(data.order, data.timeline);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Tracking',
                        text: 'Data pelacakan belum tersedia.'
                    });
                }
            } catch (e) {
                console.error(e);
                document.getElementById('trackingLoading').innerHTML = '<div class="text-danger small">Gagal memuat status pelacakan kurir.</div>';
            }
        }

        function renderTrackingData(order, timeline) {
            document.getElementById('trackingLoading').style.display = 'none';
            document.getElementById('trackingContent').style.display = 'block';

            document.getElementById('trackOrderNo').textContent = `No. Pesanan: ${order.no_pesanan}`;
            
            const badgeEl = document.getElementById('trackCourierBadge');
            badgeEl.textContent = order.ekspedisi || 'KURIR';
            const c = (order.ekspedisi || '').toUpperCase();
            if (c === 'JNE') {
                badgeEl.className = 'badge bg-primary px-3 py-2 fw-bold fs-6';
            } else if (c.includes('J&T') || c.includes('JNT')) {
                badgeEl.className = 'badge bg-danger px-3 py-2 fw-bold fs-6';
            } else if (c.includes('SICEPAT')) {
                badgeEl.className = 'badge bg-warning text-dark px-3 py-2 fw-bold fs-6';
            } else {
                badgeEl.className = 'badge bg-success px-3 py-2 fw-bold fs-6';
            }

            document.getElementById('trackCourierService').textContent = `${order.ekspedisi} - ${order.layanan_ekspedisi}`;
            document.getElementById('trackCourierEtd').textContent = `Estimasi Tiba: ${order.estimasi_pengiriman || '1-3 Hari'}`;
            
            currentTrackingResi = order.no_resi || '';
            const resiEl = document.getElementById('trackResiText');
            const copyBtn = document.getElementById('btnCopyResi');
            if (order.no_resi) {
                resiEl.textContent = order.no_resi;
                copyBtn.style.display = 'inline-block';
            } else {
                resiEl.textContent = 'Dalam proses cetak label';
                copyBtn.style.display = 'none';
            }

            document.getElementById('trackRecipient').textContent = `Penerima: ${order.nama_penerima} (${order.alamat_lengkap})`;
            document.getElementById('trackOrderStatusBadge').innerHTML = order.status_badge;

            // External link to courier tracking
            const extLink = document.getElementById('trackOfficialLink');
            if (order.no_resi) {
                extLink.href = `https://berdu.id/cek-resi?resi=${encodeURIComponent(order.no_resi)}`;
                extLink.style.display = 'inline-block';
            } else {
                extLink.style.display = 'none';
            }

            // Render timeline steps
            const container = document.getElementById('trackingTimelineContainer');
            container.innerHTML = '';

            timeline.forEach(step => {
                const stepDiv = document.createElement('div');
                stepDiv.className = `tracking-step ${step.status}`;

                let iconInner = '<i class="fa-solid fa-circle"></i>';
                if (step.status === 'completed') {
                    iconInner = '<i class="fa-solid fa-check"></i>';
                } else if (step.status === 'current') {
                    iconInner = '<i class="fa-solid fa-truck"></i>';
                }

                stepDiv.innerHTML = `
                    <div class="tracking-dot">${iconInner}</div>
                    <div class="tracking-time">${step.time}</div>
                    <div class="tracking-title">${step.title}</div>
                    ${step.location ? `<div class="tracking-location"><i class="fa-solid fa-map-pin me-1 text-muted"></i>${step.location}</div>` : ''}
                    <div class="tracking-desc">${step.description}</div>
                `;
                container.appendChild(stepDiv);
            });
        }

        function copyResi() {
            if (!currentTrackingResi) return;
            navigator.clipboard.writeText(currentTrackingResi).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Resi Disalin!',
                    text: `Nomor resi ${currentTrackingResi} berhasil disalin ke clipboard.`,
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/customer/pesanan.blade.php ENDPATH**/ ?>