

<?php echo $__env->make('penjualan-barang.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('penjualan-barang.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('penjualan-barang.show', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('penjualan-barang.import', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('content'); ?>
<div class="section-header">
    <div class="d-flex align-items-center">
        <div class="header-icon-box mr-3">
            <i class="fa fa-shopping-bag"></i>
        </div>
        <div>
            <h1>Daftar Penjualan Barang</h1>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">Kelola katalog harga, stok, diskon, dan PPN produk penjualan</p>
        </div>
    </div>
    <div class="ml-auto d-flex align-items-center" style="gap: 10px;">
        <button class="btn btn-primary" id="button_tambah_produk">
            <i class="fa fa-plus"></i> Tambah Produk
        </button>
        <button class="btn btn-success" id="importBtn">
            <i class="fa fa-file-excel"></i> Import Data
        </button>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
    <i class="fa fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header">
        <h4><i class="fa fa-table-list text-primary"></i> Data Penjualan Barang</h4>
        <div class="card-header-action">
            <div class="input-group">
                <input type="text" class="form-control search-input-pill" id="searchInput" placeholder="Cari nama atau kode produk..." style="width: 260px;">
                <div class="input-group-append">
                    <button class="btn search-clear-btn" type="button" id="clearSearch" title="Reset pencarian">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="table_id" class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Diskon</th>
                        <th class="text-center">PPN</th>
                        <th width="12%" class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal untuk Produk Tersembunyi -->
<div class="modal fade" id="modal_hidden_products" tabindex="-1" aria-labelledby="modalHiddenProductsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="modalHiddenProductsLabel">
                    <i class="fa fa-eye-slash"></i> Produk Tersembunyi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th width="15%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_hidden"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script DataTable & AJAX -->
<script>
    $(document).ready(function() {
        let searchTimeout;

        // Initialize DataTable with sorting disabled
        let table = $('#table_id').DataTable({
            responsive: true,
            ordering: false, // Disable sorting
            searching: false, // Disable default search
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
            }
        });

        loadData();

        function loadData(search = '') {
            // Show loading
            $('#tbody').html('<tr><td colspan="9" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');

            $.ajax({
                url: "<?php echo e(route('penjualan-barang.getData')); ?>",
                type: "GET",
                data: { search: search },
                success: function(response) {
                    $('#tbody').html(response.data);
                    // Initialize tooltips after data loaded
                    $('[data-toggle="tooltip"]').tooltip();
                },
                error: function() {
                    $('#tbody').html('<tr><td colspan="9" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> Gagal memuat data</td></tr>');
                }
            });
        }

        // Real-time search
        $('#searchInput').on('input', function() {
            let search = $(this).val();
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadData(search);
            }, 300); // Delay 300ms untuk menghindari terlalu banyak request
        });

        // Clear search
        $('#clearSearch').click(function() {
            $('#searchInput').val('');
            loadData();
        });

        // Tambah Produk
        $('#button_tambah_produk').click(function() {
            $('#modal_tambah_produk').modal('show');
        });

        // Store Produk
        $('#store').click(function(e) {
            e.preventDefault();
            let formData = new FormData($('#form_tambah_produk')[0]);

            // Show loading button
            let submitBtn = $(this);
            let originalText = submitBtn.html();
            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);

            $.ajax({
                url: "<?php echo e(route('penjualan-barang.store')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#modal_tambah_produk').modal('hide');
                    loadData();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(error) {
                    showValidationErrors(error.responseJSON);
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });

        // Edit Produk - tanpa AJAX, langsung ambil dari data attribute
        $('body').on('click', '.edit-btn', function() {
            let btn = $(this);
            $('#edit_id').val(btn.data('id'));
            $('#edit_nm_barang').val(btn.data('nm_barang'));
            $('#edit_deskripsi').val(btn.data('deskripsi'));
            $('#edit_kategori_id').val(btn.data('kategori_id'));
            $('#edit_satuan_id').val(btn.data('satuan_id'));
            $('#edit_harga_jual').val(btn.data('harga_jual'));
            $('#edit_harga_beli').val(btn.data('harga_beli'));
            $('#edit_stok').val(btn.data('stok'));
            $('#edit_diskon_persen').val(btn.data('diskon_persen'));
            $('#edit_ppn_persen').val(btn.data('ppn_persen'));

            $('#modal_edit_produk').modal('show');
        });

        // Update Produk
        $('#update').click(function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let formData = new FormData($('#form_edit_produk')[0]);
            formData.append('_method', 'PUT');

            // Show loading button
            let submitBtn = $(this);
            let originalText = submitBtn.html();
            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Mengupdate...').prop('disabled', true);

            $.ajax({
                url: `/penjualan-barang/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#modal_edit_produk').modal('hide');
                    loadData();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(error) {
                    showValidationErrors(error.responseJSON);
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });

        // Hapus Produk - Updated untuk menangani sembunyikan produk
        $('body').on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            let namaBarang = $(this).closest('tr').find('td:eq(2)').text();
            let token = $("meta[name='csrf-token']").attr('content');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                html: `Data <strong>${namaBarang}</strong> akan dihapus atau disembunyikan jika memiliki histori transaksi!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fa fa-trash"></i> Ya, hapus!',
                cancelButtonText: '<i class="fa fa-times"></i> Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/penjualan-barang/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            loadData();
                            let icon = response.action === 'hidden' ? 'info' : 'success';
                            Swal.fire({
                                icon: icon,
                                title: response.action === 'hidden' ? 'Disembunyikan!' : 'Terhapus!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal menghapus data', 'error');
                        }
                    });
                }
            });
        });

        // Detail Produk (Show) - menggunakan AJAX
        // Detail Produk (Show) - DENGAN DEBUG LENGKAP
$('body').on('click', '.detail-btn', function() {
    let id = $(this).data('id');

    // Show loading
    Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });

    $.ajax({
        url: `/penjualan-barang/${id}`,
        type: "GET",
        success: function(response) {
            // Close loading
            Swal.close();

            // DEBUG: Log seluruh response
            console.log('=== FULL RESPONSE ===');
            console.log(response);
            
            // DEBUG: Log khusus kategori dan satuan
            console.log('=== KATEGORI DEBUG ===');
            console.log('response.kategori:', response.kategori);
            if (response.kategori) {
                console.log('kategori.id:', response.kategori.id);
                console.log('kategori.nama_kategori:', response.kategori.nama_kategori);
            }
            
            console.log('=== SATUAN DEBUG ===');
            console.log('response.satuan:', response.satuan);
            if (response.satuan) {
                console.log('satuan.id:', response.satuan.id);
                console.log('satuan.nama_satuan:', response.satuan.nama_satuan);
            }

            // Isi data ke modal
            $('#detail_kd_barang').text(response.kd_penjualan_barang || '-');
            $('#detail_nm_barang').text(response.nm_barang || '-');
            $('#detail_deskripsi').text(response.deskripsi || '-');
            
            // PERBAIKAN KATEGORI - Multiple fallback checks
            let kategoriText = '-';
            if (response.kategori) {
                if (response.kategori.nama_kategori) {
                    kategoriText = response.kategori.nama_kategori;
                } else if (response.kategori.name) {
                    kategoriText = response.kategori.name;
                } else {
                    kategoriText = 'Kategori tidak valid';
                }
            }
            $('#detail_kategori').text(kategoriText);
            console.log('Kategori yang ditampilkan:', kategoriText);
            
            // PERBAIKAN SATUAN - Multiple fallback checks
            let satuanText = '-';
            if (response.satuan) {
                if (response.satuan.nama_satuan) {
                    satuanText = response.satuan.nama_satuan;
                } else if (response.satuan.name) {
                    satuanText = response.satuan.name;
                } else {
                    satuanText = 'Satuan tidak valid';
                }
            }
            $('#detail_satuan').text(satuanText);
            console.log('Satuan yang ditampilkan:', satuanText);
            
            // Format harga
            $('#detail_harga_beli').text(response.harga_beli ? 'Rp. ' + numberFormat(response.harga_beli) : 'Rp. 0');
            $('#detail_harga_jual').text(response.harga_jual ? 'Rp. ' + numberFormat(response.harga_jual) : 'Rp. 0');
            
            // Stok
            $('#detail_stok').text(response.stok !== null && response.stok !== undefined ? response.stok : '0');
            
            // Diskon dan PPN
            $('#detail_diskon').text(response.diskon_persen !== null && response.diskon_persen !== undefined ? response.diskon_persen + '%' : '0%');
            $('#detail_kena_ppn').text(response.ppn_persen !== null && response.ppn_persen !== undefined ? response.ppn_persen + '%' : '0%');

            // Show modal
            $('#modal_detail_produk').modal('show');
        },
        error: function(xhr, status, error) {
            Swal.close();
            console.log('=== ERROR DEBUG ===');
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);
            console.log('Status Code:', xhr.status);
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengambil data detail: ' + error,
                confirmButtonText: 'OK'
            });
        }
    });
});

        // Hidden Products
        $('#hiddenProductsBtn').click(function() {
            loadHiddenProducts();
            $('#modal_hidden_products').modal('show');
        });

       // Ganti bagian loadHiddenProducts() dalam script JavaScript

function loadHiddenProducts() {
    $('#tbody_hidden').html('<tr><td colspan="7" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');

    $.ajax({
        // PERBAIKAN: Gunakan route name yang benar
        url: "<?php echo e(route('penjualan-barang.hidden')); ?>",
        type: "GET",
        success: function(response) {
            $('#tbody_hidden').html(response.data);
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            console.log('Status:', status);
            console.log('Response:', xhr.responseText);
            $('#tbody_hidden').html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>');
        }
    });
}

        // Restore hidden product
        $('body').on('click', '.restore-btn', function() {
            let id = $(this).data('id');
            let namaBarang = $(this).closest('tr').find('td:eq(2)').text();
            let token = $("meta[name='csrf-token']").attr('content');

            Swal.fire({
                title: 'Kembalikan produk?',
                html: `Produk <strong>${namaBarang}</strong> akan dikembalikan ke daftar aktif`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-undo"></i> Ya, kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/penjualan-barang/${id}/restore`,
                        type: 'POST',
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            loadHiddenProducts();
                            loadData(); // Refresh main table
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal mengembalikan produk', 'error');
                        }
                    });
                }
            });
        });

        // Force delete hidden product
        $('body').on('click', '.force-delete-btn', function() {
            let id = $(this).data('id');
            let namaBarang = $(this).closest('tr').find('td:eq(2)').text();
            let token = $("meta[name='csrf-token']").attr('content');

            Swal.fire({
                title: 'Hapus permanen?',
                html: `Produk <strong>${namaBarang}</strong> akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash"></i> Ya, hapus permanen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/penjualan-barang/${id}/force-delete`,
                        type: 'POST',
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            loadHiddenProducts();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal menghapus produk', 'error');
                        }
                    });
                }
            });
        });

        // Import Excel
        $('#importBtn').click(function() {
            $('#modal_import').modal('show');
        });

        $('#startImport').click(function() {
            $('#form_import').submit();
        });

        // Validasi Error
        function showValidationErrors(errors) {
            $('.alert-danger').remove();
            if (errors) {
                $.each(errors, function(key, value) {
                    $(`#${key}`).after(`<div class="alert alert-danger mt-1">${value[0]}</div>`);
                });
            }
        }

        // Function helper untuk format number
        function numberFormat(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\App-Penjualan\resources\views/penjualan-barang/index.blade.php ENDPATH**/ ?>