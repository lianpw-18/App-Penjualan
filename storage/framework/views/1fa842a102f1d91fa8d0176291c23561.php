

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
        <div>
            <h3 class="fw-bold mb-1"><i class="fa-solid fa-cart-shopping me-2 text-primary"></i>Kelola Pesanan Online (Web E-Commerce)</h3>
            <p class="text-muted small mb-0">Kelola order calon pelanggan, atur nomor resi kurir, dan verifikasi status pembayaran</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Total Pesanan</div>
                        <h4 class="fw-bold mb-0 text-dark"><?php echo e($totalOrders); ?></h4>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <i class="fa-solid fa-receipt fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Menunggu Bayar</div>
                        <h4 class="fw-bold mb-0 text-warning"><?php echo e($pendingOrders); ?></h4>
                    </div>
                    <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                        <i class="fa-solid fa-clock fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Sedang Dikirim</div>
                        <h4 class="fw-bold mb-0 text-info"><?php echo e($shippingOrders); ?></h4>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-circle">
                        <i class="fa-solid fa-truck-fast fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-muted">Pesanan Selesai</div>
                        <h4 class="fw-bold mb-0 text-success"><?php echo e($completedOrders); ?></h4>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('pesanan-admin.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Cari No. Pesanan / Nama / Resi..." value="<?php echo e($search); ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all">Semua Status</option>
                        <option value="menunggu_pembayaran" <?php echo e($status === 'menunggu_pembayaran' ? 'selected' : ''); ?>>Menunggu Pembayaran</option>
                        <option value="diproses" <?php echo e($status === 'diproses' ? 'selected' : ''); ?>>Sedang Dikemas (Diproses)</option>
                        <option value="dikirim" <?php echo e($status === 'dikirim' ? 'selected' : ''); ?>>Sedang Dikirim</option>
                        <option value="selesai" <?php echo e($status === 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                        <option value="dibatalkan" <?php echo e($status === 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo e(route('pesanan-admin.index')); ?>" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Pesanan & Tanggal</th>
                        <th>Pelanggan & Alamat</th>
                        <th>Ekspedisi</th>
                        <th>Item & Total</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?php echo e($order->no_pesanan); ?></div>
                                <div class="small text-muted"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></div>
                                <div class="badge bg-light text-dark border small mt-1"><?php echo e($order->metode_pembayaran_label); ?></div>
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo e($order->nama_penerima); ?></div>
                                <div class="small text-muted"><i class="fa-brands fa-whatsapp text-success me-1"></i><?php echo e($order->no_telepon); ?></div>
                                <div class="small text-secondary text-truncate" style="max-width: 220px;" title="<?php echo e($order->alamat_lengkap); ?><?php echo e($order->kelurahan ? ', Kel. ' . $order->kelurahan : ''); ?><?php echo e($order->kecamatan ? ', Kec. ' . $order->kecamatan : ''); ?>, <?php echo e($order->kota); ?>">
                                    <?php echo e($order->kecamatan ? $order->kecamatan . ', ' : ''); ?><?php echo e($order->kota); ?>

                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary fw-bold"><?php echo e($order->ekspedisi); ?></span>
                                <div class="small text-muted"><?php echo e($order->layanan_ekspedisi); ?></div>
                                <div class="small text-success fw-semibold"><?php echo e($order->formatted_ongkir); ?></div>
                                <?php if($order->no_resi): ?>
                                    <div class="small text-dark fw-bold mt-1">Resi: <?php echo e($order->no_resi); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">
                                    <?php echo e($order->detailPesanans->sum('jumlah')); ?> pcs
                                </div>
                                <div class="fw-bold text-primary fs-6"><?php echo e($order->formatted_total_bayar); ?></div>
                            </td>
                            <td>
                                <?php echo $order->status_badge; ?>

                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" onclick="openStatusModal(<?php echo e($order->id); ?>, '<?php echo e($order->no_pesanan); ?>', '<?php echo e($order->status_pesanan); ?>', '<?php echo e($order->no_resi ?? ''); ?>')">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Update Status
                                </button>
                                <a href="<?php echo e(route('checkout.success', ['no_pesanan' => $order->no_pesanan])); ?>" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill ms-1" title="Lihat Struk">
                                    <i class="fa-solid fa-receipt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fs-2 mb-2 d-block opacity-50"></i>
                                Tidak ada data pesanan online.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($pesanans->hasPages()): ?>
            <div class="card-footer bg-white py-3">
                <?php echo e($pesanans->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Update Status & Resi -->
<div class="modal fade" id="modalUpdateStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Update Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <form id="formUpdateStatus">
                    <input type="hidden" id="editOrderId">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Status Pesanan</label>
                        <select id="editStatusSelect" class="form-select">
                            <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                            <option value="diproses">Sedang Dikemas (Diproses)</option>
                            <option value="dikirim">Sedang Dikirim</option>
                            <option value="selesai">Selesai (Paket Diterima)</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div class="mb-3" id="resiInputGroup">
                        <label class="form-label small fw-bold">Nomor Resi Ekspedisi (Tracking Number)</label>
                        <input type="text" id="editResiInput" class="form-control" placeholder="Contoh: JNE10928374829">
                        <div class="form-text small">Nomor resi dapat dilihat oleh pelanggan untuk tracking kiriman.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveStatus()">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let statusModalInstance = null;

    function openStatusModal(id, noPesanan, status, resi) {
        document.getElementById('editOrderId').value = id;
        document.getElementById('modalTitle').textContent = 'Update ' + noPesanan;
        document.getElementById('editStatusSelect').value = status;
        document.getElementById('editResiInput').value = resi;

        if (!statusModalInstance) {
            statusModalInstance = new bootstrap.Modal(document.getElementById('modalUpdateStatus'));
        }
        statusModalInstance.show();
    }

    function saveStatus() {
        const id = document.getElementById('editOrderId').value;
        const status = document.getElementById('editStatusSelect').value;
        const resi = document.getElementById('editResiInput').value.trim();

        fetch(`/admin/pesanan-online/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                status_pesanan: status,
                no_resi: resi
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                statusModalInstance.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1200
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message
                });
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan sistem.'
            });
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\App-Penjualan\resources\views/pesanan-admin/index.blade.php ENDPATH**/ ?>