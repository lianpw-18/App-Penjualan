<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - <?php echo e($pesanan->no_pesanan); ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary: #5f27cd;
            --primary-light: #f3f0fb;
            --tokopedia-green: #03ac0e;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            padding: 40px 0;
        }
        .invoice-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .invoice-header {
            background: linear-gradient(135deg, #5f27cd, #833ab4);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .bank-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 12px;
            padding: 16px 20px;
            margin: 16px 0;
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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            
            <div class="invoice-card">
                <div class="invoice-header">
                    <i class="fa-solid fa-circle-check fs-1 text-warning mb-2"></i>
                    <h3 class="fw-bold mb-1">Terima Kasih, Pesanan Berhasil Dibuat!</h3>
                    <p class="mb-0 text-white-50">Nomor Pesanan: <strong><?php echo e($pesanan->no_pesanan); ?></strong></p>
                </div>

                <div class="p-4 p-md-5">
                    
                    <!-- Status Badge -->
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <span class="text-muted small">Status Pesanan:</span>
                        <div><?php echo $pesanan->status_badge; ?></div>
                    </div>

                    <!-- Payment Details -->
                    <?php if(in_array($pesanan->status_pesanan, ['diproses', 'dikirim', 'selesai'])): ?>
                        <div class="alert alert-success border-0 d-flex align-items-center gap-3 mb-4 p-3 rounded-3 shadow-sm" style="background-color: #f0fdf4; border-left: 5px solid #22c55e !important;">
                            <i class="fa-solid fa-circle-check fs-2 text-success"></i>
                            <div>
                                <h6 class="fw-bold text-success mb-1">Pembayaran Berhasil Dikonfirmasi! (Lunas)</h6>
                                <p class="small text-muted mb-0">
                                    Pembayaran sebesar <strong><?php echo e($pesanan->formatted_total_bayar); ?></strong> via <?php echo e($pesanan->metode_pembayaran_label); ?> telah berhasil diverifikasi pada <?php echo e(($pesanan->tgl_pembayaran ?? $pesanan->updated_at)->format('d M Y, H:i')); ?> WIB. Paket Anda saat ini sedang diproses oleh penjual.
                                </p>
                            </div>
                        </div>

                        <!-- Live Tracking Card directly on page -->
                        <div class="card border rounded-3 p-3 mb-4 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-truck-fast text-success fs-5"></i>
                                    <h6 class="fw-bold text-dark mb-0">Status Pengiriman Kurir</h6>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="openTrackingModal('<?php echo e($pesanan->no_pesanan); ?>')">
                                    <i class="fa-solid fa-expand me-1"></i> Buka Detail Lacak
                                </button>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col-sm-6">
                                    <span class="badge bg-primary px-2.5 py-1.5 fw-bold"><?php echo e($pesanan->ekspedisi); ?></span>
                                    <span class="fw-bold text-dark ms-1"><?php echo e($pesanan->layanan_ekspedisi); ?></span>
                                    <div class="small text-muted mt-1">Estimasi tiba: <?php echo e($pesanan->estimasi_pengiriman); ?></div>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <span class="small text-muted">No. Resi:</span>
                                    <strong class="text-primary font-monospace fs-6"><?php echo e($pesanan->no_resi ?: 'Dalam proses cetak resi'); ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php elseif(str_contains($pesanan->metode_pembayaran, 'transfer') && isset($bankAccounts[$pesanan->metode_pembayaran])): ?>
                        <?php $bank = $bankAccounts[$pesanan->metode_pembayaran]; ?>
                        <div class="alert alert-warning border-0 d-flex align-items-center gap-2 mb-3">
                            <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                            <div>Silakan lakukan pembayaran sebesar <strong><?php echo e($pesanan->formatted_total_bayar); ?></strong> ke rekening berikut:</div>
                        </div>

                        <div class="bank-box d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge <?php echo e($bank['badge']); ?> mb-1"><?php echo e($bank['bank']); ?></span>
                                <div class="fs-4 fw-bold text-dark" id="rekNumber"><?php echo e($bank['no_rek']); ?></div>
                                <div class="small text-muted">a.n. <?php echo e($bank['an']); ?></div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyRekening('<?php echo e($bank['no_rek']); ?>')">
                                <i class="fa-regular fa-copy me-1"></i> Salin Rekening
                            </button>
                        </div>
                    <?php elseif($pesanan->metode_pembayaran === 'qris'): ?>
                        <div class="text-center my-3 p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold">Scan QRIS untuk Pembayaran</h6>
                            <p class="small text-muted mb-2">Bisa menggunakan GoPay, OVO, Dana, BCA Mobile, atau ShopeePay</p>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=BUTIK-GAMIS-<?php echo e($pesanan->no_pesanan); ?>-<?php echo e($pesanan->total_bayar); ?>" alt="QRIS" class="img-fluid rounded border p-2 bg-white shadow-sm mb-2">
                            <div class="fw-bold text-dark fs-5"><?php echo e($pesanan->formatted_total_bayar); ?></div>
                        </div>
                    <?php elseif($pesanan->metode_pembayaran === 'cod'): ?>
                        <div class="alert alert-success border-0 d-flex align-items-center gap-3 mb-3">
                            <i class="fa-solid fa-hand-holding-dollar fs-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Pesanan COD (Bayar di Tempat)</h6>
                                <p class="small mb-0">Siapkan uang tunai pas sebesar <strong><?php echo e($pesanan->formatted_total_bayar); ?></strong> saat kurir <strong><?php echo e($pesanan->ekspedisi); ?></strong> mengantarkan paket ke alamat Anda.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Detail Info -->
                    <h6 class="fw-bold mt-4 mb-3"><i class="fa-solid fa-truck-fast me-2 text-primary"></i>Informasi Pengiriman</h6>
                    <table class="table table-sm table-borderless text-muted small mb-4">
                        <tr>
                            <td style="width: 140px;">Penerima:</td>
                            <td class="text-dark fw-semibold"><?php echo e($pesanan->nama_penerima); ?> (<?php echo e($pesanan->no_telepon); ?>)</td>
                        </tr>
                        <tr>
                            <td>Alamat:</td>
                            <td class="text-dark"><?php echo e($pesanan->alamat_lengkap); ?><?php echo e($pesanan->kelurahan ? ', Kel. ' . $pesanan->kelurahan : ''); ?><?php echo e($pesanan->kecamatan ? ', Kec. ' . $pesanan->kecamatan : ''); ?>, <?php echo e($pesanan->kota); ?>, <?php echo e($pesanan->provinsi); ?> <?php echo e($pesanan->kode_pos); ?></td>
                        </tr>
                        <tr>
                            <td>Ekspedisi:</td>
                            <td class="text-dark fw-semibold"><?php echo e($pesanan->ekspedisi); ?> - <?php echo e($pesanan->layanan_ekspedisi); ?> (Ongkir: <?php echo e($pesanan->formatted_ongkir); ?>)</td>
                        </tr>
                        <?php if($pesanan->no_resi): ?>
                        <tr>
                            <td>No. Resi:</td>
                            <td class="text-primary fw-bold"><?php echo e($pesanan->no_resi); ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>

                    <!-- Rincian Produk -->
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-bag-shopping me-2 text-primary"></i>Item yang Dibeli</h6>
                    <div class="border rounded-3 p-3 mb-4 bg-light">
                        <?php $__currentLoopData = $pesanan->detailPesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <div class="fw-bold text-dark"><?php echo e($detail->nm_barang); ?></div>
                                    <div class="small text-muted"><?php echo e($detail->jumlah); ?> x <?php echo e($detail->formatted_harga_satuan); ?></div>
                                </div>
                                <div class="fw-bold text-dark"><?php echo e($detail->formatted_subtotal); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="d-flex justify-content-between pt-3 text-dark fw-bold fs-5">
                            <span>Total Pembayaran</span>
                            <span class="text-primary"><?php echo e($pesanan->formatted_total_bayar); ?></span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary py-2.5 fw-bold" onclick="openTrackingModal('<?php echo e($pesanan->no_pesanan); ?>')">
                            <i class="fa-solid fa-truck-fast me-2"></i> Lacak Pengiriman Paket
                        </button>

                        <a href="<?php echo e($waConfirmUrl); ?>" target="_blank" class="btn btn-success py-2.5 fw-bold shadow-sm">
                            <i class="fa-brands fa-whatsapp me-2 fs-5"></i> Konfirmasi ke Admin via WhatsApp
                        </a>

                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('customer.pesanan')); ?>" class="btn btn-outline-secondary py-2 fw-semibold">
                                <i class="fa-solid fa-list-check me-2"></i> Lihat Riwayat Pesanan Saya
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-secondary py-2 fw-semibold">
                                <i class="fa-solid fa-arrow-left me-2"></i> Kembali Belanja di Katalog
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentTrackingResi = '';

    function copyRekening(rek) {
        navigator.clipboard.writeText(rek).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Nomor rekening disalin!',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }

    async function openTrackingModal(noPesanan) {
        const modalEl = document.getElementById('trackingModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        document.getElementById('trackingLoading').style.display = 'block';
        document.getElementById('trackingContent').style.display = 'none';

        try {
            const res = await fetch(`<?php echo e(url('/checkout/tracking')); ?>/${encodeURIComponent(noPesanan)}`);
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

    // Auto open modal if auto_track query param is present
    if (new URLSearchParams(window.location.search).get('auto_track') === '1') {
        setTimeout(() => {
            openTrackingModal('<?php echo e($pesanan->no_pesanan); ?>');
        }, 500);
    }
</script>

</body>
</html>
<?php /**PATH C:\laragon\www\PPN Penjualan\resources\views/checkout/success.blade.php ENDPATH**/ ?>