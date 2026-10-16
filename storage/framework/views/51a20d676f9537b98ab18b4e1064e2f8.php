<!-- Modal Tambah Produk Keluar -->
<div class="modal fade" id="modal_tambah_barangKeluar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Produk Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="form_produk_keluar">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Supplier <span style="color: red">*</span></label>
                                <select class="form-control" name="supplier_id" id="supplier_id">
                                    <option value="">Pilih Supplier</option>
                                    <!-- DEBUG: Tampilkan jumlah data -->
                                    <?php echo e(count($suppliers ?? [])); ?> data supplier
                                    <?php $__empty_1 = true; $__currentLoopData = $suppliers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($supplier->id); ?>">
                                            <?php echo e($supplier->supplier ?? $supplier->nm_supplier ?? $supplier->nama ?? 'No Name'); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value="" disabled>Tidak ada data supplier</option>
                                    <?php endif; ?>
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-supplier_id"></div>
                            </div>
                            <div class="form-group">
                                <label>Pilih Produk <span style="color: red">*</span></label>
                                <select class="form-control" name="nm_produk" id="nm_produk">
                                    <option value="">Pilih Supplier terlebih dahulu</option>
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nm_produk"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Stok Keluar <span style="color: red">*</span></label>
                                    <!-- PERBAIKAN: Hapus min="1" untuk memungkinkan input ratusan -->
                                    <input type="number" class="form-control" name="stok_keluar" id="stok_keluar" 
                                           min="1" step="1" placeholder="Masukkan jumlah stok keluar">
                                    <small class="form-text text-muted">Masukkan jumlah stok keluar (minimal 1)</small>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-stok_keluar"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Stok Tersedia</label>
                                    <input type="number" class="form-control" name="stok_tersedia" id="stok_tersedia" readonly>
                                    <!-- PERBAIKAN: Tambah info stok maksimal -->
                                    <small class="form-text text-info" id="stok-info"></small>
                                </div>
                            </div>
                        </div>
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Keluar</label>
                                <input type="date" class="form-control" name="tgl_keluar" id="tgl_keluar" readonly>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi/Keterangan <span style="color: red">*</span></label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" placeholder="Masukkan keterangan produk keluar..."></textarea>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <p class="text-left mr-auto">
                    <span style="color: red">*</span> Form wajib diisi!
                </p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                <button type="button" class="btn btn-primary" id="store">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script untuk validasi stok -->
<script>
$(document).ready(function() {
    // Validasi input stok keluar
    $('#stok_keluar').on('input', function() {
        let stokKeluar = parseInt($(this).val()) || 0;
        let stokTersedia = parseInt($('#stok_tersedia').val()) || 0;
        
        // Reset alert
        $('#alert-stok_keluar').addClass('d-none');
        
        if (stokKeluar <= 0) {
            $('#alert-stok_keluar').text('Stok keluar harus lebih dari 0').removeClass('d-none');
            $(this).addClass('is-invalid');
        } else if (stokKeluar > stokTersedia) {
            $('#alert-stok_keluar').text('Stok keluar melebihi stok tersedia!').removeClass('d-none');
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });
    
    // Update info stok saat produk dipilih
    $(document).on('change', '#nm_produk', function() {
        let nmProduk = $(this).val();
        
        if(nmProduk) {
            $.ajax({
                url: '/produk-keluar/get-produk-detail',
                type: 'GET',
                data: { nm_produk: nmProduk },
                success: function(response) {
                    if(response.success) {
                        $('#stok_tersedia').val(response.stok);
                        // Tampilkan info stok
                        $('#stok-info').text('Stok tersedia: ' + response.stok);
                        
                        // Reset validasi stok keluar
                        $('#stok_keluar').removeClass('is-valid is-invalid');
                        $('#alert-stok_keluar').addClass('d-none');
                    }
                }
            });
        } else {
            $('#stok_tersedia').val('');
            $('#stok-info').text('');
        }
    });
    
    // Validasi form saat submit
    $('#store').click(function(e) {
        e.preventDefault();
        
        let stokKeluar = parseInt($('#stok_keluar').val()) || 0;
        let stokTersedia = parseInt($('#stok_tersedia').val()) || 0;
        
        // Reset alerts
        $('.alert-danger').addClass('d-none');
        $('.is-invalid').removeClass('is-invalid');
        
        // Validasi stok
        if (stokKeluar <= 0) {
            $('#alert-stok_keluar').text('Stok keluar harus lebih dari 0').removeClass('d-none');
            $('#stok_keluar').addClass('is-invalid');
            return;
        }
        
        if (stokKeluar > stokTersedia) {
            $('#alert-stok_keluar').text('Stok keluar melebihi stok tersedia! Maksimal: ' + stokTersedia).removeClass('d-none');
            $('#stok_keluar').addClass('is-invalid');
            return;
        }
        
        // Lanjutkan dengan submit form
        // ... kode submit form yang sudah ada
    });
});
</script><?php /**PATH C:\Users\user\App-Penjualan\resources\views/produk-keluar/create.blade.php ENDPATH**/ ?>