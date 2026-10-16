<!-- Modal Create/Edit Produk Masuk -->
<div class="modal fade" id="modal_tambah_barangMasuk" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_tambah_produk_masuk">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <!-- Alert Success -->
                    <div class="alert alert-success d-none" id="alert-success">
                        <strong>Berhasil!</strong> Data produk masuk berhasil disimpan.
                    </div>

                    <!-- Pilih Pembelian Barang -->
                    <div class="form-group">
                        <label>Pilih Pembelian Barang <span class="text-danger">*</span></label>
                        <select name="pembelian_barang_id" id="pembelian_barang_id" class="form-control" required>
                            <option value="">-- Pilih Pembelian Barang --</option>
                            <?php echo e(count($pembelianBarang ?? [])); ?> data pembelian
                            <?php $__empty_1 = true; $__currentLoopData = $pembelianBarang ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($item->id); ?>">
                                    <?php echo e($item->kd_pembelian_barang ?? 'No Code'); ?> - <?php echo e($item->nm_barang ?? 'No Name'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="" disabled>Tidak ada data pembelian barang</option>
                            <?php endif; ?>
                        </select>
                        <div class="alert alert-danger d-none" id="alert-pembelian_barang_id"></div>
                    </div>

                    <!-- Detail Barang (akan muncul setelah memilih) -->
                    <div class="form-group d-none" id="detail_barang">
                        <label>Detail Barang</label>
                        <div class="card">
                            <div class="card-body">
                                <div id="info_barang"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Tanggal Masuk -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control" required>
                                <div class="alert alert-danger d-none" id="alert-tgl_masuk"></div>
                            </div>
                        </div>

                        <!-- Stok Masuk -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stok Masuk <span class="text-danger">*</span></label>
                                <input type="number" name="stok_masuk" id="stok_masuk" class="form-control" min="1" required>
                                <div class="alert alert-danger d-none" id="alert-stok_masuk"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier -->
                    <div class="form-group">
                        <label>Supplier <span class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php echo e(count($suppliers ?? [])); ?> data supplier
                            <?php $__empty_1 = true; $__currentLoopData = $suppliers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->supplier ?? $supplier->nama ?? 'No Name'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="" disabled>Tidak ada data supplier</option>
                            <?php endif; ?>
                        </select>
                        <div class="alert alert-danger d-none" id="alert-supplier_id"></div>
                    </div>

                    <!-- Informasi -->
                    <div class="alert alert-info">
                        <small>
                            <strong>Catatan:</strong><br>
                            - Harga beli dan nama produk akan diambil otomatis dari data pembelian barang<br>
                            - Total harga akan dihitung otomatis: Stok Masuk × Harga Beli<br>
                            - Stok produk akan bertambah sesuai dengan stok masuk yang diinput
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="store">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\Users\user\App-Penjualan\resources\views/produk-masuk/create.blade.php ENDPATH**/ ?>